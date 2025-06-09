package middleware

import (
	"log"
	"net/http"
	"time"
)

func LoggingMiddleware(next http.HandlerFunc) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		start := time.Now()

		// Log request
		log.Printf("📥 [%s] %s %s", r.Method, r.URL.Path, r.RemoteAddr)

		// Create custom response writer to capture status code
		rw := &responseWriter{
			ResponseWriter: w,
			statusCode:     http.StatusOK,
		}

		// Call next handler
		next(rw, r)

		// Calculate duration
		duration := time.Since(start)

		// Log response
		log.Printf("📤 [%s] %s - Status: %d - Duration: %v",
			r.Method,
			r.URL.Path,
			rw.statusCode,
			duration,
		)
	}
}

// Custom response writer to capture status code
type responseWriter struct {
	http.ResponseWriter
	statusCode int
}

func (rw *responseWriter) WriteHeader(code int) {
	rw.statusCode = code
	rw.ResponseWriter.WriteHeader(code)
}
