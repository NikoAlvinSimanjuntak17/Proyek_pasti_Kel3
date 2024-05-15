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
	db                 *gorm.DB                      = config.SetupDatabaseConnection()
	categoryRepository repository.CategoryRepository = repository.NewCategoryRepository(db)
	categoryService    service.CategoryService       = service.NewCategoryService(categoryRepository)
	categoryController controller.CategoryController = controller.NewCategoryController(categoryService)
)

// membuat variable db dengan nilai setup database connection
func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()
	
	categoryRoutes := r.Group("/api/categories")
	{
		categoryRoutes.GET("/", categoryController.All)
		categoryRoutes.POST("/", categoryController.Insert)
		categoryRoutes.GET("/:id", categoryController.FindByID)
		categoryRoutes.PUT("/:id", categoryController.Update)
		categoryRoutes.DELETE("/:id", categoryController.Delete)
	}
	r.Run(":9092")
}
