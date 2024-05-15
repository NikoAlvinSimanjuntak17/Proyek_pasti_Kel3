package dto

type ReservationCreateDTO struct {
	UserID  uint64 `json:"user_id" form:"user_id" binding:"required"`
	Name    string `json:"name" form:"name" binding:"required"`
	Email   string `json:"email" form:"email" binding:"required"`
	Phone   string `json:"phone" form:"phone" binding:"required"`
	Date    string `json:"date" form:"date" binding:"required"`
	Time    string `json:"time" form:"time" binding:"required"`
	People  uint64 `json:"people" form:"people" binding:"required"`
	Message string `json:"message" form:"message"`
}

type ReservationUpdateDTO struct {
	ID      uint64 `json:"id" form:"id" binding:"required"`
	Name    string `json:"name" form:"name" binding:"required"`
	Email   string `json:"email" form:"email" binding:"required"`
	Phone   string `json:"phone" form:"phone" binding:"required"`
	Date    string `json:"date" form:"date" binding:"required"`
	Time    string `json:"time" form:"time" binding:"required"`
	People  uint64 `json:"people" form:"people" binding:"required"`
	Message string `json:"message" form:"message"`
	Status  string `json:"status" form:"status" binding:"required"`
}
