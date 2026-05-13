require("dotenv").config();

const express = require("express");
const mongoose = require("mongoose");

const User = require("./models/User");
const authRoutes = require("./routes/authRoutes");
const eventRoutes = require("./routes/eventRoutes");
const bookingRoutes = require("./routes/bookingRoutes");

const protect = require("./middleware/authMiddleware");
const adminOnly = require("./middleware/adminMiddleware");

const app = express();

app.use(express.json());

// Routes
app.use("/api/auth", authRoutes);
app.use("/api/events", eventRoutes);
app.use("/api/bookings", bookingRoutes);

// MongoDB connection
mongoose
  .connect(process.env.MONGO_URI)
  .then(() => console.log("MongoDB Connected"))
  .catch((err) => console.log(err));

// Root route
app.get("/", (req, res) => {
  res.send("API working");
});

// Test route (create user)
app.get("/test-user", async (req, res) => {
  try {
    const user = new User({
      name: "Test",
      email: "test@test.com",
      password: "123456",
    });

    await user.save();

    res.json(user);
  } catch (error) {
    console.log(error);

    res.status(500).json({
      message: error.message,
      fullError: error,
    });
  }
});

// Protected route
app.get("/protected", protect, (req, res) => {
  res.json({
    message: "You accessed protected route",
    user: req.user,
  });
});

// Admin-only route test
app.post("/admin-test", protect, adminOnly, (req, res) => {
  res.json({
    message: "Welcome admin!",
  });
});

const notFound = require("./middleware/notFound");
app.use(notFound);

// Start server
app.listen(3000, () => {
  console.log("Server running on port 3000");
});
