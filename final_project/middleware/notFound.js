const notFound = (req, res, next) => {
  res.status(404);

  if (req.headers.accept && req.headers.accept.includes("text/html")) {
    res.send("<h1>404 Not Found</h1>");
  } else {
    res.json({ error: "404 Not Found" });
  }
};

module.exports = notFound;
