 Trip Builder — Backend API (Laravel)

This project is a backend REST API built with Laravel for the **Trip Builder coding assignment**.

It allows building and retrieving trips for a single passenger using available flights, while handling pricing, dates, and business rules.

---

##  Tech Stack

- PHP 8+
- Laravel
- MySQL / MariaDB
- Carbon (date & timezone handling)

---

## Installation & Setup

### Prerequisites

- PHP 8+
- Composer
- MySQL / MariaDB
- Git

---

### Install dependencies

```bash
composer install

---

### Environment configuration
Run migrations & seeders
** php artisan migrate:fresh --seed
Start the server
** php artisan serve
API Endpoints
GET /api/airports

Returns the list of available airports.

Response example

[
  {
    "code": "YUL",
    "city": "Montreal",
    "timezone": "America/Montreal"
  },
  {
    "code": "YVR",
    "city": "Vancouver",
    "timezone": "America/Vancouver"
  }
]
GET /api/flights

Returns the list of available flights with related airline and airports.

Response example

[
  {
    "number": "301",
    "price": 273.23,
    "airline": {
      "code": "AC",
      "name": "Air Canada"
    },
    "departure_airport": {
      "code": "YUL",
      "city": "Montreal"
    },
    "arrival_airport": {
      "code": "YVR",
      "city": "Vancouver"
    }
  }
]
POST /api/trips/search

Builds a trip (one-way or round-trip) based on search criteria.

Request (One-way)
{
  "from": "YUL",
  "to": "YVR",
  "departure_date": "2026-03-10",
  "type": "one_way"
}

Request (Round-trip)
{
  "from": "YUL",
  "to": "YVR",
  "departure_date": "2026-03-10",
  "return_date": "2026-03-15",
  "type": "round_trip"
}

Response
{
  "trip_id": 1,
  "type": "round_trip",
  "total_price": 540.46,
  "flights": [
    {
      "number": "301",
      "airline": { "code": "AC", "name": "Air Canada" },
      "departure_airport": { "code": "YUL" },
      "arrival_airport": { "code": "YVR" },
      "departure_time": "08:00",
      "arrival_time": "11:15"
    },
    {
      "number": "302",
      "airline": { "code": "AC", "name": "Air Canada" },
      "departure_airport": { "code": "YVR" },
      "arrival_airport": { "code": "YUL" },
      "departure_time": "14:00",
      "arrival_time": "21:20"
    }
  ]
}
GET /api/trips/{id}

Returns the details of a previously created trip.

Request
GET /api/trips/1

Response
{
  "id": 1,
  "type": "round_trip",
  "total_price": 540.46,
  "flights": [
    {
      "number": "301",
      "airline": { "code": "AC", "name": "Air Canada" },
      "departure_airport": { "code": "YUL" },
      "arrival_airport": { "code": "YVR" }
    }
  ]
}
---