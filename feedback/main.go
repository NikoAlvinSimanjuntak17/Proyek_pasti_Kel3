package main

import (
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/config"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/controller"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/repository"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/service"
	"github.com/gin-gonic/gin"
	"gorm.io/gorm"
)

var (
    db                *gorm.DB                     = config.SetupDatabaseConnection()
	feedbackRepository repository.FeedbackRepository = repository.NewFeedbackRepository(db)
	FeedbackService    service.FeedbackService       = service.NewFeedbackService(feedbackRepository)
	feedbackController controller.FeedbackController = controller.NewFeedbackController(FeedbackService)
)

func main() {
    defer config.CloseDatabaseConnection(db)
    r := gin.Default()

    // Grouping product routes
    feedbackRoutes := r.Group("/api/feedbacks")
	{
		feedbackRoutes.GET("/", feedbackController.All)
		feedbackRoutes.POST("/", feedbackController.Insert)
		feedbackRoutes.GET("/:id", feedbackController.FindByID)
	}

    r.Run(":9095")
}
