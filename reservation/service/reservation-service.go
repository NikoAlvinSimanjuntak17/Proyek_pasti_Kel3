package service

import (
	"log"

	"github.com/marloxxx/microservices-go/backend/reservation_service/dto"
	"github.com/marloxxx/microservices-go/backend/reservation_service/entity"
	"github.com/marloxxx/microservices-go/backend/reservation_service/repository"
	"github.com/mashingan/smapping"
)

type ReservationService interface {
	Insert(b dto.ReservationCreateDTO) entity.Reservation
	Update(b dto.ReservationUpdateDTO) entity.Reservation
	Delete(b entity.Reservation)
	All(userID uint64) []entity.Reservation
}

type reservationService struct {
	reservationRepository repository.ReservationRepository
}

func NewReservationService(reservationRepository repository.ReservationRepository) ReservationService {
	return &reservationService{
		reservationRepository: reservationRepository,
	}
}

func (service *reservationService) Insert(b dto.ReservationCreateDTO) entity.Reservation {
	reservation := entity.Reservation{}
	err := smapping.FillStruct(&reservation, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.reservationRepository.InsertReservation(reservation)
	return res
}

func (service *reservationService) Update(b dto.ReservationUpdateDTO) entity.Reservation {
	reservation := entity.Reservation{}
	err := smapping.FillStruct(&reservation, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.reservationRepository.UpdateReservation(reservation)
	return res
}

func (service *reservationService) Delete(b entity.Reservation) {
	service.reservationRepository.DeleteReservation(b)
}

func (service *reservationService) All(userID uint64) []entity.Reservation {
	return service.reservationRepository.All(userID)
}
