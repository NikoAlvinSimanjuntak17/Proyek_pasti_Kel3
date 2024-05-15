package repository

import (
	"github.com/NikoAlvinSimanjuntak17/golang_gin_gorm_JWT/entity"
	"gorm.io/gorm"
)

type FeedbackRepository interface {
	InsertFeedback(feedback entity.Feedback) entity.Feedback
	All() []entity.Feedback
	FindByID(feedbackID uint64) entity.Feedback
}

type feedbackConnection struct {
	connection *gorm.DB
}

func NewFeedbackRepository(db *gorm.DB) FeedbackRepository {
	return &feedbackConnection{
		connection: db,
	}
}

func (db *feedbackConnection) InsertFeedback(feedback entity.Feedback) entity.Feedback {
	db.connection.Save(&feedback)
	return feedback
}

func (db *feedbackConnection) All() []entity.Feedback {
	var feedbacks []entity.Feedback
	db.connection.Find(&feedbacks)
	return feedbacks
}

func (db *feedbackConnection) FindByID(feedbackID uint64) entity.Feedback {
	var feedback entity.Feedback
	db.connection.Find(&feedback, feedbackID)
	return feedback
}
