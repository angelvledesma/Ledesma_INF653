//NPM modules 
const {format} = require('date-fns');
const { v4: uuidv4 } = require ('uuid');

//Core modules 
const fs = require('fs');
const path = require('path');


// logEvents function
const logEvents = async (message) => {
    const logId = uuidv4();
    const timestamp = format(new Date(), 'yyyy-MM-dd HH:mm:ss');
    const logEntry = `${logId}\t[${timestamp}]\t${message}\n`;

    try {
        // Ensure 'logs' folder exists
        if (!fs.existsSync(path.join(__dirname, 'logs'))) {
            fs.mkdirSync(path.join(__dirname, 'logs'));
        }

        // Append log entry to eventLog.txt
        fs.promises.appendFile(path.join(__dirname, 'logs', 'eventLog.txt'), logEntry);
    } catch (err) {
        console.error('Error writing to log file:', err);
    }
};

module.exports = logEvents;