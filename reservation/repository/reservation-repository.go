package repository

import (
	"github.com/marloxxx/microservices-go/backend/reservation_service/entity"
	"gorm.io/gorm"
)

type ReservationRepository interface {
	InsertReservation(reservation entity.Reservation) entity.Reservation
	UpdateReservation(reservation entity.Reservation) entity.Reservation
	All(userID uint64) []entity.Reservation
	DeleteReservation(reservation entity.Reservation)
}

type reservationConnection struct {
	connection *gorm.DB
}

func NewReservationRepository(db *gorm.DB) ReservationRepository {
	return &reservationConnection{
		connection: db,
	}
}

func (db *reservationConnection) InsertReservation(reservation entity.Reservation) entity.Reservation {
	db.connection.Save(&reservation)
	return reservation
}

func (db *reservationConnection) UpdateReservation(reservation entity.Reservation) entity.Reservation {
	db.connection.Save(&reservation)
	return reservation
}

func (db *reservationConnection) All(userID uint64) []entity.Reservation {
	var reservations []entity.Reservation
	db.connection.Find(&reservations, "user_id = ?", userID)
	return reservations
}

func (db *reservationConnection) DeleteReservation(reservation entity.Reservation) {
	db.connection.Delete(&reservation)
}
