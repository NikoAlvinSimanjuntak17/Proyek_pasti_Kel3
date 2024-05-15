package controller

import (
	"net/http"
	"strconv"

	"github.com/gin-gonic/gin"
	"github.com/marloxxx/microservices-go/backend/reservation_service/dto"
	"github.com/marloxxx/microservices-go/backend/reservation_service/entity"
	"github.com/marloxxx/microservices-go/backend/reservation_service/helper"
	"github.com/marloxxx/microservices-go/backend/reservation_service/service"
)

type ReservationController interface {
	All(ctx *gin.Context)
	Insert(ctx *gin.Context)
	Update(ctx *gin.Context)
	Delete(ctx *gin.Context)
}

type reservationController struct {
	ReservationService service.ReservationService
}

func NewReservationController(ReservationService service.ReservationService) ReservationController {
	return &reservationController{
		ReservationService: ReservationService,
	}
}

func (c *reservationController) All(ctx *gin.Context) {
	userID, err := strconv.ParseUint(ctx.Query("user_id"), 0, 0)
	if err != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	reservations := c.ReservationService.All(userID)
	res := helper.BuildResponse(true, "OK!", reservations)
	ctx.JSON(http.StatusOK, res)
}

func (c *reservationController) Insert(ctx *gin.Context) {
	var reservationCreateDTO dto.ReservationCreateDTO
	errDTO := ctx.ShouldBind(&reservationCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	result := c.ReservationService.Insert(reservationCreateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusCreated, response)
}

func (c *reservationController) Update(ctx *gin.Context) {
	var reservationUpdateDTO dto.ReservationUpdateDTO
	errDTO := ctx.ShouldBind(&reservationUpdateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	id, errID := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if errID != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	reservationUpdateDTO.ID = id
	result := c.ReservationService.Update(reservationUpdateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusOK, response)
}

func (c *reservationController) Delete(ctx *gin.Context) {
	var reservation entity.Reservation
	id, errID := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if errID != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	reservation.ID = id
	c.ReservationService.Delete(reservation)
	res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
	ctx.JSON(http.StatusOK, res)
}
