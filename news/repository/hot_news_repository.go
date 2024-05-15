package repository

import (
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/entity"
	"gorm.io/gorm"
)
type HotNewsRepository interface {
	InsertHotNews(hotNews entity.HotNews) entity.HotNews
	UpdateHotNews(hotNews entity.HotNews) entity.HotNews
	AllHotNews() []entity.HotNews
	FindHotNewsByID(hotNewsID uint64) entity.HotNews
	DeleteHotNews(hotNews entity.HotNews)
}

type hotNewsConnection struct {
	connection *gorm.DB
}

func NewHotNewsRepository(db *gorm.DB) HotNewsRepository {
	return &hotNewsConnection{
		connection: db,
	}
}

func (db *hotNewsConnection) InsertHotNews(hotNews entity.HotNews) entity.HotNews {
	db.connection.Save(&hotNews)
	return hotNews
}

func (db *hotNewsConnection) UpdateHotNews(hotNews entity.HotNews) entity.HotNews {
	db.connection.Save(&hotNews)
	return hotNews
}

func (db *hotNewsConnection) AllHotNews() []entity.HotNews {
	var hotNews []entity.HotNews
	db.connection.Find(&hotNews)
	return hotNews
}

func (db *hotNewsConnection) FindHotNewsByID(hotNewsID uint64) entity.HotNews {
	var hotNews entity.HotNews
	db.connection.Find(&hotNews, hotNewsID)
	return hotNews
}

func (db *hotNewsConnection) DeleteHotNews(hotNews entity.HotNews) {
	db.connection.Delete(&hotNews)
}
