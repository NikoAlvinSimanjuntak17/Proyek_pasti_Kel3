package entity

import "gorm.io/gorm"

type Feedback struct {
	gorm.Model
	ID      uint64 `gorm:"primary_key:auto_increment"`
	UserID  uint64 `gorm:"type:int" json:"user_id" validate:"required"`
	Content string `gorm:"type:varchar(255)" json:"content" validate:"required,min=3,max=255"`
}

