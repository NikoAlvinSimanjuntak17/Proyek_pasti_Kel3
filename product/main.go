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
    productRepository repository.ProductRepository = repository.NewProductRepository(db)
    ProductService    service.ProductService       = service.NewProductService(productRepository)
    productController controller.ProductController = controller.NewProductController(ProductService)
)

func main() {
    defer config.CloseDatabaseConnection(db)
    r := gin.Default()

    // Grouping product routes
    productRoutes := r.Group("/api/products")
    {
        productRoutes.GET("/", productController.All)
        productRoutes.POST("/", productController.Insert)
        productRoutes.GET("/:id", productController.FindByID)
        productRoutes.PUT("/:id", productController.Update)
        productRoutes.DELETE("/:id", productController.Delete)

        // New endpoint for fetching products by category ID
        productRoutes.GET("/category/:category_id", productController.AllByCategory)
    }

    r.Run(":9091")
}
