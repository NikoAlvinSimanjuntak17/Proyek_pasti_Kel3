package entity

import "gorm.io/gorm"

type Category struct {
	gorm.Model
	ID          uint64 `gorm:"primary_key:auto_increment"`                                             // set primary key and auto increment untuk kolom id
	Name        string `gorm:"type:varchar(255)" json:"name" validate:"required,min=3,max=255"`        // set tipe data varchar untuk kolom name
}
