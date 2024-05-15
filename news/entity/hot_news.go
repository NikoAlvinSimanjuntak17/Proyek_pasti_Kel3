package entity

import "gorm.io/gorm"

type HotNews struct {
	gorm.Model
	Title   string `gorm:"type:varchar(255)" json:"title" validate:"required,min=3,max=255"`
	Content string `gorm:"type:text" json:"content" validate:"required"`
}
