package dto

type FeedbackCreateDTO struct {
	UserID  uint64 `json:"user_id" form:"user_id" binding:"required"`
	Content string `json:"content" form:"content" binding:"required,min=3,max=255"`
}
