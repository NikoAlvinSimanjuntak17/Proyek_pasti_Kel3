package service

import (
	"log"

	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/dto"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/entity"
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/repository"
	"github.com/mashingan/smapping"
)

type HotNewsService interface {
	Insert(hotNewsData dto.HotNewsCreateDTO) entity.HotNews
	Update(hotNewsData dto.HotNewsUpdateDTO) entity.HotNews
	Delete(hotNews entity.HotNews)
	All() []entity.HotNews
	FindByID(hotNewsID uint64) entity.HotNews
}

type hotNewsService struct {
	hotNewsRepository repository.HotNewsRepository
}

func NewHotNewsService(hotNewsRepository repository.HotNewsRepository) HotNewsService {
	return &hotNewsService{
		hotNewsRepository: hotNewsRepository,
	}
}

func (service *hotNewsService) All() []entity.HotNews {
	return service.hotNewsRepository.AllHotNews()
}

func (service *hotNewsService) FindByID(hotNewsID uint64) entity.HotNews {
	return service.hotNewsRepository.FindHotNewsByID(hotNewsID)
}

func (service *hotNewsService) Insert(hotNewsData dto.HotNewsCreateDTO) entity.HotNews {
	hotNews := entity.HotNews{}
	err := smapping.FillStruct(&hotNews, smapping.MapFields(&hotNewsData))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.hotNewsRepository.InsertHotNews(hotNews)
	return res
}

func (service *hotNewsService) Update(hotNewsData dto.HotNewsUpdateDTO) entity.HotNews {
	hotNews := entity.HotNews{}
	err := smapping.FillStruct(&hotNews, smapping.MapFields(&hotNewsData))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.hotNewsRepository.UpdateHotNews(hotNews)
	return res
}

func (service *hotNewsService) Delete(hotNews entity.HotNews) {
	service.hotNewsRepository.DeleteHotNews(hotNews)
}
