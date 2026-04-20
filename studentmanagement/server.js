const express = require("express");
const dotenv = require("dotenv");
const connectDB = require("./dbConfig");
const studentRoutes = require("./routes/studentRoutes");

dotenv.config();

connectDB();

const app = express();

app.use(express.json());

app.use("/students", studentRoutes);

app.get("/", (req, res) => {
  res.send("Student Management API is running");
});

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
