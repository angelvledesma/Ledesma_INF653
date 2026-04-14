const express = require("express");
const app = express();

const path = require("path");
const PORT = 3000;

const errorHandler = require("./errorHandler");

app.get(["/", "/index.html"], (req, res) => {
  res.sendFile(path.join(__dirname, "views", "index.html"));
});

app.get("/user/:userID/book/:bookID", (req, res) => {
  const { userID, bookID } = req.params;
  res.send(`User ID: ${userID}, Book ID: ${bookID}`);
});

app.get("/user/:id", (req, res) => {
  const userId = req.params.id || "No ID Provided";
  res.send(`User ID: ${userId}`);
});

app.get("/old-page", (req, res) => {
  res.redirect(301, "/new-page");
});

app.get("/new-page", (req, res) => {
  res.sendFile(path.join(__dirname, "views", "about.html"));
});

app.get(
  "/multi",
  (req, res, next) => {
    console.log("first handler executed");
    req.data = "Data from first handler";
    next();
  },
  (req, res, next) => {
    console.log("second handler executed");
    req.data = "Data from second handler";
    next();
  },
  (req, res) => {
    console.log("third handler executed");
    res.send(`Final response: ${req.data}`);
  },
);

app.get("/error", (req, res) => {
  throw new Error("This is a test error route!");
});

app.use(errorHandler);

app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
