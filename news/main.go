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
	hotNewsRepository repository.HotNewsRepository     = repository.NewHotNewsRepository(db)
	hotNewsService    service.HotNewsService           = service.NewHotNewsService(hotNewsRepository)
	hotNewsController controller.HotNewsController   = controller.NewHotNewsController(hotNewsService)
    )

func main() {
    defer config.CloseDatabaseConnection(db)
    r := gin.Default()

    // Grouping product routes
    hotNewsRoutes := r.Group("/api/hot-news")
    {
        hotNewsRoutes.GET("/", hotNewsController.All)
        hotNewsRoutes.POST("/", hotNewsController.Insert)
        hotNewsRoutes.GET("/:id", hotNewsController.FindByID)
        hotNewsRoutes.PUT("/:id", hotNewsController.Update)
        hotNewsRoutes.DELETE("/:id", hotNewsController.Delete)
    }

    r.Run(":9099")
}
