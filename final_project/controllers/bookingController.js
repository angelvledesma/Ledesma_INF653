const Booking = require("../models/Booking");
const Event = require("../models/Event");

// CREATE BOOKING
exports.createBooking = async (req, res) => {
  try {
    const { eventId, quantity } = req.body;

    const event = await Event.findById(eventId);

    if (!event) {
      return res.status(404).json({ message: "Event not found" });
    }

    const remainingSeats = event.seatCapacity - event.bookedSeats;

    if (quantity > remainingSeats) {
      return res.status(400).json({ message: "Not enough seats available" });
    }

    // update booked seats
    event.bookedSeats += quantity;
    await event.save();

    const booking = await Booking.create({
      user: req.user.id,
      event: eventId,
      quantity,
    });

    res.status(201).json(booking);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
};

exports.getMyBookings = async (req, res) => {
  try {
    const bookings = await Booking.find({ user: req.user.id })
      .populate("event")
      .populate("user", "name email");

    res.json(bookings);
  } catch (error) {
    res.status(500).json({ message: error.message });
  }
};
