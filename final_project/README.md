# Event Ticketing System API

This is a simple REST API for an Event Ticketing System built with Node.js, Express, and MongoDB.  
It allows users to register, log in, view events, and book tickets. Admins can create and manage events.

---

# Features

## User Features

- Register and login
- View all events
- Filter events by category or date
- Book tickets for events
- View only their own bookings

## Admin Features

- Create events
- Update events
- Delete events (with booking protection)

---

# Tech Used

- Node.js
- Express
- MongoDB + Mongoose
- JWT Authentication
- bcryptjs

---

# Installation

1. Clone the project

git clone <your-repo-link>
cd final_project

2. Install Dependencies

- npm install

3. Create .env file

- PORT=3000
  MONGO_URI=your_mongodb_connection_string
  JWT_SECRET=your_secret_key

4. Start the server
   npm run dev

5. open in browser

- http://localhost:3000

# Testing

- Use Thunder Client VS Code Extension

# Authentication

- Protected routes require a token
