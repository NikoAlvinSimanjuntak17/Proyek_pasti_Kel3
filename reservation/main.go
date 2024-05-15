package main

import (
	"github.com/gin-gonic/gin"
	"github.com/marloxxx/microservices-go/backend/reservation_service/config"
	"github.com/marloxxx/microservices-go/backend/reservation_service/controller"
	"github.com/marloxxx/microservices-go/backend/reservation_service/repository"
	"github.com/marloxxx/microservices-go/backend/reservation_service/service"
	"gorm.io/gorm"
)

var (
	db                   *gorm.DB                       = config.SetupDatabaseConnection()
	reservationRepository repository.ReservationRepository = repository.NewReservationRepository(db)
	ReservationService   service.ReservationService     = service.NewReservationService(reservationRepository)
	reservationController controller.ReservationController = controller.NewReservationController(ReservationService)
)

func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	reservationRoutes := r.Group("/api/reservations")
	{
		reservationRoutes.GET("/", reservationController.All)
		reservationRoutes.POST("/", reservationController.Insert)
		reservationRoutes.PUT("/:id", reservationController.Update)
		reservationRoutes.DELETE("/:id", reservationController.Delete)
	}
	r.Run(":9097")
}
