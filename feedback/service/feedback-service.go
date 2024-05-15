package service

import (
	"log"

	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/dto"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/entity"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/repository"
	"github.com/mashingan/smapping"
)

type FeedbackService interface {
	Insert(b dto.FeedbackCreateDTO) entity.Feedback
	All() []entity.Feedback
	FindByID(feedbackID uint64) entity.Feedback
}

type feedbackService struct {
	feedbackRepository repository.FeedbackRepository
}

// NewFeedbackService creates a new instance of FeedbackService
func NewFeedbackService(feedbackRepository repository.FeedbackRepository) FeedbackService {
	return &feedbackService{
		feedbackRepository: feedbackRepository,
	}
}

func (service *feedbackService) All() []entity.Feedback {
	return service.feedbackRepository.All()
}

func (service *feedbackService) FindByID(feedbackID uint64) entity.Feedback {
	return service.feedbackRepository.FindByID(feedbackID)
}

func (service *feedbackService) Insert(b dto.FeedbackCreateDTO) entity.Feedback {
	feedback := entity.Feedback{}
	err := smapping.FillStruct(&feedback, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.feedbackRepository.InsertFeedback(feedback)
	return res
}
