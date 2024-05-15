package entity

type Reservation struct {
	ID         uint64 `gorm:"primary_key:auto_increment"`
	UserID     uint64 `gorm:"type:int(11)"`
	Name       string `gorm:"type:varchar(255)"`
	Email      string `gorm:"type:varchar(255)"`
	Phone      string `gorm:"type:varchar(20)"`
	Date       string `gorm:"type:date"`
	Time       string `gorm:"type:time"`
	People     uint64 `gorm:"type:int(11)"`
	Message    string `gorm:"type:text"`
	Status     string `gorm:"type:enum('pending','approved','rejected','canceled');default:'pending'"`
}
