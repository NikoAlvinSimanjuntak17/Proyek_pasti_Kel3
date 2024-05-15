package controller

import (
	"net/http"
	"strconv"

	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/dto"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/entity"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/helper"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/service"
	"github.com/gin-gonic/gin"
)

type HotNewsController interface {
	All(ctx *gin.Context)
	FindByID(ctx *gin.Context)
	Insert(ctx *gin.Context)
	Update(ctx *gin.Context)
	Delete(ctx *gin.Context)
}

type hotNewsController struct {
	hotNewsService service.HotNewsService
}

func NewHotNewsController(hotNewsService service.HotNewsService) HotNewsController {
	return &hotNewsController{
		hotNewsService: hotNewsService,
	}
}

func (c *hotNewsController) All(ctx *gin.Context) {
	hotNewsList := c.hotNewsService.All()
	res := helper.BuildResponse(true, "OK!", hotNewsList)
	ctx.JSON(http.StatusOK, res)
}

func (c *hotNewsController) FindByID(ctx *gin.Context) {
	id, err := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if err != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	hotNews := c.hotNewsService.FindByID(id)
	if (hotNews == entity.HotNews{}) {
		res := helper.BuildErrorResponse("Data not found", "No data with given ID", helper.EmptyObj{})
		ctx.JSON(http.StatusNotFound, res)
	} else {
		res := helper.BuildResponse(true, "OK!", hotNews)
		ctx.JSON(http.StatusOK, res)
	}
}

func (c *hotNewsController) Insert(ctx *gin.Context) {
	var hotNewsCreateDTO dto.HotNewsCreateDTO
	errDTO := ctx.ShouldBind(&hotNewsCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	result := c.hotNewsService.Insert(hotNewsCreateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusCreated, response)
}

func (c *hotNewsController) Update(ctx *gin.Context) {
	var hotNewsUpdateDTO dto.HotNewsUpdateDTO
	errDTO := ctx.ShouldBind(&hotNewsUpdateDTO)
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
hotNewsUpdateDTO.ID = uint(id)
	result := c.hotNewsService.Update(hotNewsUpdateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusOK, response)
}



func (c *hotNewsController) Delete(ctx *gin.Context) {
	var hotNews entity.HotNews
	idStr := ctx.Param("id")
	id, errID := strconv.ParseUint(idStr, 0, 64)
	if errID != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	hotNews.ID = uint(id) // Konversi tipe uint64 ke uint
	c.hotNewsService.Delete(hotNews)
	res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
	ctx.JSON(http.StatusOK, res)
}

