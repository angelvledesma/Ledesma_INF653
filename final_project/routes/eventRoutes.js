const express = require("express");
const router = express.Router();

const protect = require("../middleware/authMiddleware");
const adminOnly = require("../middleware/adminMiddleware");

const {
  createEvent,
  getEvents,
  deleteEvent,
} = require("../controllers/eventController");

// routes
router.post("/", protect, adminOnly, createEvent);
router.get("/", getEvents);
router.delete("/:id", protect, adminOnly, deleteEvent);

module.exports = router;
