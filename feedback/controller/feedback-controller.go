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

type FeedbackController interface {
	All(ctx *gin.Context)
	FindByID(ctx *gin.Context)
	Insert(ctx *gin.Context)
}

type feedbackController struct {
	FeedbackService service.FeedbackService
}

// NewFeedbackController creates a new instance of FeedbackController
func NewFeedbackController(FeedbackService service.FeedbackService) FeedbackController {
	return &feedbackController{
		FeedbackService: FeedbackService,
	}
}

func (c *feedbackController) All(ctx *gin.Context) {
	var feedbacks []entity.Feedback = c.FeedbackService.All()
	res := helper.BuildResponse(true, "OK!", feedbacks)
	ctx.JSON(http.StatusOK, res)
}

func (c *feedbackController) FindByID(ctx *gin.Context) {
	id, err := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if err != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	feedback := c.FeedbackService.FindByID(id)
	if (feedback == entity.Feedback{}) {
		res := helper.BuildErrorResponse("Data not found", "No data with given ID", helper.EmptyObj{})
		ctx.JSON(http.StatusNotFound, res)
	} else {
		res := helper.BuildResponse(true, "OK!", feedback)
		ctx.JSON(http.StatusOK, res)
	}
}

func (c *feedbackController) Insert(ctx *gin.Context) {
	var feedbackCreateDTO dto.FeedbackCreateDTO
	errDTO := ctx.ShouldBind(&feedbackCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	result := c.FeedbackService.Insert(feedbackCreateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusCreated, response)
}
