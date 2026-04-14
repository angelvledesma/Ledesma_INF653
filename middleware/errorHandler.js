const fs = require("fs");
const path = require("path");

const logFile = path.join(__dirname, "..", "logs", "errorLog.txt");

function errorHandler(err, req, res, next) {
  const timestamp = new Date().toISOString();

  const logEntry = `
========================
TIME: ${timestamp}
NAME: ${err.name}
MESSAGE: ${err.message}
STACK: ${err.stack}
========================\n`;

  fs.appendFile(logFile, logEntry, (fsErr) => {
    if (fsErr) {
      console.error("Failed to write error log:", fsErr);
    }
  });

  console.error(err);

  res.status(500).send("Something went wrong on the server.");
}

module.exports = errorHandler;
