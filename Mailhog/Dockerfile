# Multi-stage build for MailHog 1.0.1 using vendor
FROM golang:1.18-alpine AS builder

# Set GOPATH
ENV GOPATH /go
ENV GO111MODULE off

# Put the code in the expected location for pre-module Go
WORKDIR /go/src/github.com/mailhog/MailHog
COPY temp_mailhog/MailHog-1.0.1/ .

# Build the binary
RUN go build -o /usr/local/bin/MailHog main.go

# Final stage
FROM alpine:latest

# Add mailhog user
RUN adduser -D -u 1000 mailhog

# Copy binary from builder
COPY --from=builder /usr/local/bin/MailHog /usr/local/bin/MailHog

USER mailhog
WORKDIR /home/mailhog

ENTRYPOINT ["MailHog"]

# Expose the SMTP and HTTP ports:
EXPOSE 1025 8025
