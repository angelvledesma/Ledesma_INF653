const Event = require("../models/Event");
const Booking = require("../models/Booking");

// CREATE EVENT (admin only)
exports.createEvent = async (req, res) => {
  try {
    const event = await Event.create(req.body);

    res.status(201).json(event);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
};

exports.deleteEvent = async (req, res) => {
  try {
    const eventId = req.params.id;

    const bookings = await Booking.find({ event: eventId });

    if (bookings.length > 0) {
      return res.status(400).json({
        message: "Cannot delete event with existing bookings",
      });
    }

    await Event.findByIdAndDelete(eventId);

    res.json({ message: "Event deleted successfully" });
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
};

exports.getEvents = async (req, res) => {
  try {
    const { category, date } = req.query;

    let filter = {};

    if (category) {
      filter.category = category;
    }

    if (date) {
      const start = new Date(date);
      const end = new Date(date);
      end.setDate(end.getDate() + 1);

      filter.date = {
        $gte: start,
        $lt: end,
      };
    }

    const events = await Event.find(filter);

    res.json(events);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
};
