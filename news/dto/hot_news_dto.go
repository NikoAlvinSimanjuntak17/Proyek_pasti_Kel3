package dto

type HotNewsCreateDTO struct {
	Title   string `json:"title" form:"title" binding:"required,min=3,max=255"`
	Content string `json:"content" form:"content" binding:"required"`
}

type HotNewsUpdateDTO struct {
	ID      uint   `json:"id" form:"id" binding:"required"`
	Title   string `json:"title" form:"title" binding:"required,min=3,max=255"`
	Content string `json:"content" form:"content" binding:"required"`
}