//jshint esversion:6
//cd OneDrive/Desktop/Swetha/Academics/guvi

const express = require("express");
const bodyParser = require("body-parser");

const app = express();
app.use(bodyParser.json());

app.use(
  bodyParser.urlencoded({
    extended: true,
  })
);
app.use(express.static("public"));
app.set("view engine", "ejs"); //tells the app to use ejs view engine
app.set("view options", {
  layout: false,
});

//Connect to database guvi
const mongoose = require("mongoose");
mongoose.connect(
  "mongodb+srv://admin-swetha:Spiderman@cluster0.z3exi.mongodb.net/guvi",
  { useNewUrlParser: true }
);
var db = mongoose.connection;
db.on("error", console.log.bind(console, "connection error"));
db.once("open", function (callback) {
  console.log("connection succeeded");
});

app.post("/signin", function (req, res) {
  var ran = "Welcome!";
  res.render("signin", { ran_data: ran });
  console.log("In login page");
});

app.get("/signin", function (req, res) {
  res.redirect("/profile");
});

app.post("/profile", function (req, res) {
  console.log("inside profile");

  var name = req.body.name;
  var email = req.body.email;
  var dob = req.body.dob;
  var cont = req.body.cont;
  var pass = req.body.pass;
  var prof = req.body.prof;
  var nat = req.body.nat;

  var data = {
    Name: name,
    Email: email,
    DOB: dob,
    Contact: cont,
    Password: pass,
    Profession: prof,
    Nationality: nat,
  };

  var msg = "Welcome to your profile page!";

  if (typeof data.Password === "undefined") {
    //update pg- no password
    console.log("From update page");
    var name = req.body.name.trim();
    var email = req.body.email.trim();
    var dob = req.body.dob.trim();
    var cont = req.body.cont.trim();
    var prof = req.body.prof.trim();
    var nat = req.body.nat.trim();
    console.log(email);
    console.log(name);

    const filter = { Email: email };
    const update = {
      Name: name,
      DOB: dob,
      Contact: cont,
      Profession: prof,
      Nationality: nat,
    };

    db.collection("details").findOneAndUpdate(
      //calback
      filter,
      { $set: update },
      { new: true, upsert: true, returnOriginal: false },
      (error, data) => {
        if (error) throw error;
        console.log("---------");
        console.log(data);
        console.log("---------");
        res.render("profile", { p_data: data.value });
        console.log("Rendered");
      }
    );
  } else if (typeof data.Name === "undefined") {
    console.log("From login page"); //login page-only email and pass
    console.log(email);
    console.log(pass);
    if (typeof email === "undefined") email = "";
    db.collection("details").findOne({ Email: email }, (error, data) => {
      if (error) throw error;
      if (data !== null && data.Password === pass) {
        console.log("---------");
        console.log(data);
        console.log("---------");
        res.render("profile", { p_data: data });
        console.log("Rendered");
      } else {
        var empty = "";
        var data = {
          Name: empty,
          Email: empty,
          DOB: empty,
          Contact: empty,
          Password: empty,
          Profession: empty,
          Nationality: empty,
        };
        res.render("profile", { p_data: data });
      }
    });
  } else {
    console.log("From signup page");
    db.collection("details").insertOne(data, function (err, collection) {
      if (err) throw err;
      console.log("Record inserted Successfully");
      res.render("profile", { p_data: data });
    });
  }
});

app.post("/update", function (req, res) {
  console.log("Inside Update from profile");
  var msg = "Enter ALL the details to update:";
  res.render("update", { msg_data: msg });
  console.log("From update page");
});
app.get("/update", function (req, res) {
  console.log("Rerirecting update to profile");
  res.redirect("/profile");
});

let port = process.env.PORT;
if (port == null || port == "") {
  port = 3000;
}

app
  .get("/", function (req, res) {
    res.set({
      "Access-control-Allow-Origin": "*",
    });
    return res.redirect("/index.html");
  })
  .listen(port);
console.log("Server started sucessfully!");

//cd OneDrive/Desktop/Swetha/Academics/guvi
