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

type ProductController interface {
	All(ctx *gin.Context)
	FindByID(ctx *gin.Context)
	Insert(ctx *gin.Context)
	Update(ctx *gin.Context)
	Delete(ctx *gin.Context)
	AllByCategory(ctx *gin.Context)
}

type productController struct {
	ProductService service.ProductService
}

// NewProductController creates a new instance of AuthController
func NewProductController(ProductService service.ProductService) ProductController {
	return &productController{
		ProductService: ProductService,
	}
}

func (c *productController) All(ctx *gin.Context) {
	var categories []entity.Product = c.ProductService.All()
	res := helper.BuildResponse(true, "OK!", categories)
	ctx.JSON(http.StatusOK, res)
}

func (c *productController) FindByID(ctx *gin.Context) {
	id, err := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if err != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	product := c.ProductService.FindByID(id)
	if (product == entity.Product{}) {
		res := helper.BuildErrorResponse("Data not found", "No data with given ID", helper.EmptyObj{})
		ctx.JSON(http.StatusNotFound, res)
	} else {
		res := helper.BuildResponse(true, "OK!", product)
		ctx.JSON(http.StatusOK, res)
	}
}

func (c *productController) Insert(ctx *gin.Context) {
	var productCreateDTO dto.ProductCreateDTO
	errDTO := ctx.ShouldBind(&productCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	result := c.ProductService.Insert(productCreateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusCreated, response)
}

func (c *productController) Update(ctx *gin.Context) {
	var productUpdateDTO dto.ProductUpdateDTO
	errDTO := ctx.ShouldBind(&productUpdateDTO)
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
	productUpdateDTO.ID = id
	result := c.ProductService.Update(productUpdateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusOK, response)
}

func (c *productController) Delete(ctx *gin.Context) {
	var product entity.Product
	id, errID := strconv.ParseUint(ctx.Param("id"), 0, 0)
	if errID != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	product.ID = id
	c.ProductService.Delete(product)
	res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
	ctx.JSON(http.StatusOK, res)
}
func (c *productController) AllByCategory(ctx *gin.Context) {
    categoryID, err := strconv.ParseUint(ctx.Param("category_id"), 0, 0)
    if err != nil {
        res := helper.BuildErrorResponse("Failed to get category ID", "No category ID param found", helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    products := c.ProductService.AllByCategory(categoryID)
    res := helper.BuildResponse(true, "OK!", products)
    ctx.JSON(http.StatusOK, res)
}

