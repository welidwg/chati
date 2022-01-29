const express = require('express');
const mongo = require("mongodb").MongoClient;
const app = express();
const ObjectId = require('mongodb').ObjectId;
const moment = require('moment');
const multer = require("multer");

var storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, "public/messages/")
    },
    filename: (req, file, cb) => {
        cb(null, Date.now() + file.originalname)
    }
})

var upload = multer({
    storage: storage
})


const server = require("http").createServer(app);

const io = require("socket.io")(server, {
    cors: {
        origin: "*"
    }
});
mongo.connect("mongodb+srv://root:root@devconnector.mymn2.mongodb.net/DevConnector?retryWrites=true&w=majority", function (err, cl) {
    if (err) {
        throw err;
    }
    try {


        console.log("mongo connected");
        var db = cl.db("DevConnector");
        let current = new Date();
        console.log(moment(current).format("dddd ll"));
        io.on("connection", (socket) => {

            console.log("connection");
            console.log(socket.id);
            let chat = db.collection('chats');
            let actor = db.collection('actors');
            let post = db.collection('posts');
            let notif = db.collection('notifications');

            socket.on("disconnect", (socket) => {
                console.log("disconnect");
            });

            socket.on('join', function (data) {
                socket.join(data.room);
                console.log("joined");
            });
            socket.on("like1", data => {
                let idpost = data.id_post;
                post.find({
                    _id: new ObjectId(idpost)
                }).toArray((err, res) => {
                    if (err)
                        throw err;
                    if (res) {
                        if (res[0].likes) {
                            socket.emit("likeNo", {
                                id_post: idpost,
                                likes: res[0].likes,
                                div: data.iddiv

                            })
                        } else {
                            socket.emit("likeNo", {
                                id_post: idpost,
                                likes: 0,
                                div: data.iddiv

                            })
                        }

                    }
                })

            })
            socket.on("checkLike", data => {
                try {
                    let ok = false;
                    let idpost = data.id_post;
                    let iduser = data.id;
                    let div = data.iddiv;
                    post.find({
                        _id: new ObjectId(idpost)
                    }).toArray((err, rs) => {
                        if (err)
                            throw err;
                        if (rs[0].likes != 0) {

                            if (rs[0].liked_by._id.length > 0) {
                                rs[0].liked_by._id.forEach(element => {
                                    if (element === iduser) {

                                        post.updateOne({
                                            _id: new ObjectId(idpost)
                                        }, {
                                            $pull: {
                                                "liked_by._id": iduser
                                            },
                                            $inc: {
                                                "likes": -1

                                            }
                                        });
                                        ok = true;

                                        socket.emit("dislike", div);
                                        notif.findOneAndDelete({
                                            title: "New Post Like",
                                            idpost: idpost,
                                            from: iduser
                                        });
                                        console.log("deleted notif");
                                        return false;
                                    } else {
                                        console.log("not exist");
                                    }

                                });
                            }
                            console.log(ok);

                            if (!ok) {
                                console.log("ok is false");
                                post.updateOne({
                                    _id: new ObjectId(idpost)
                                }, {
                                    $push: {
                                        "liked_by._id": iduser
                                    },
                                    $inc: {
                                        "likes": +1

                                    }
                                });
                                console.log("liking");

                                socket.emit("like", div);
                                post.find({
                                    _id: new ObjectId(idpost)
                                }).toArray((err, res) => {
                                    if (err)
                                        throw err;
                                    let from = res[0].from;
                                    actor.find({
                                        _id: new ObjectId(iduser)
                                    }).toArray((error, result) => {
                                        if (error)
                                            throw error;
                                        let name = result[0].nom;
                                        let avatar = result[0].avatar;
                                        notif.insertOne({
                                            title: "New Post Like",
                                            subject: `${name} has liked your post`,
                                            idpost: idpost,
                                            from: iduser,
                                            to: from
                                        });

                                    })
                                });



                            }
                        } else {
                            console.log("likes 0");

                            post.updateOne({
                                _id: new ObjectId(idpost)
                            }, {
                                $set: {
                                    "likes": 1
                                },
                                $push: {
                                    "liked_by._id": iduser
                                }
                            });
                            socket.emit("like", div);
                            post.find({
                                _id: new ObjectId(idpost)
                            }).toArray((err, res) => {
                                if (err)
                                    throw err;
                                let from = res[0].from;
                                actor.find({
                                    _id: new ObjectId(iduser)
                                }).toArray((error, result) => {
                                    if (error)
                                        throw error;
                                    let name = result[0].nom;
                                    notif.insertOne({
                                        title: "New Post Like",
                                        subject: `${name} has liked your post`,
                                        idpost: idpost,
                                        from: iduser,
                                        to: from
                                    });

                                })
                            });


                        }
                    });
                } catch (error) {
                    console.log(error.message);

                }

            });


            socket.on("checkStatus", (id) => {
                actor.find({
                    _id: new ObjectId(id)
                }).toArray((err, res) => {
                    socket.emit("online", res[0].logged);
                })

            })
            let ck = false;
            let rm = "";
            socket.on("typing", room => {
                ck = true;
                rm = room;
                socket.to(room).emit('isTyping', ck);

            })
            socket.to(rm).emit('isTyping', false);


            socket.on("showMsg", (data, room) => {

                let idchat = data.idchat;
                chat.find({
                    id: idchat
                }).toArray(function (err, res) {
                    if (err) {
                        throw err;
                    }
                    //Emit the messages
                    //io.to(room).emit('Init', res);
                    io.to(room).emit('Init', res)
                });
            })
            var user = [];
            var tt;

            socket.on("chats", (id) => {
                chat.find({
                    $or: [{
                        "between.user1": id
                    }, {
                        "between.user2": id
                    }]
                }).toArray((err, res) => {
                    if (err)
                        throw err;
                    if (res.length != 0) {
                        let userD = "";
                        console.log(res.length);
                        for (var i = 0; i < res.length; i++) {
                            if (res[i].between.user1 == id) {
                                userD = res[i].between.user2;

                            } else {
                                userD = res[i].between.user1;
                            }
                            user.push(userD)


                        }
                        io.to(id).emit("messages", res, user);



                        /* if (res[0].between.user1 == id) {
                             user = res[0].between.user2;

                         } else {
                             user = res[0].between.user1
                         }
                         actor.find({
                                 _id: new ObjectId(user)
                             })
                             .toArray((err, resp) => {
                                 if (err)
                                     throw err
                                 console.log(resp[0].nom);
                                 if (resp) {
                                     io.to(id).emit("messages", res, resp);
                                 }
                             })*/


                    }
                })

            })





            socket.on("input", function (data, room) {
                let to = data.to;
                let from = data.from;
                let image = data.image
                let content = data.content;
                let d = moment(current);
                let date = d.format("dddd ll");
                let time = moment(current.getTime()).format("h:m a");
                let idchat = data.id;
                let pic = "";

                if (image) {
                    pic = image;
                }



                let test = chat.countDocuments({
                    id: idchat
                }, (err, count) => {
                    if (count > 0) {

                        console.log(count);
                        chat.updateOne({
                            id: idchat
                        }, {
                            $push: {
                                messages: {
                                    from: from,
                                    to: to,
                                    content: content,
                                    date: date,
                                    time: time,
                                    image: pic

                                }
                            }
                        }, (err, res) => {
                            if (err)
                                throw err;
                            actor.find({
                                _id: new ObjectId(from)
                            }).toArray((err, res) => {
                                io.to(to).emit("msgNumber", res[0].nom, content);

                            })
                            io.to(room).emit("outputS", [data]);



                        });
                    } else {
                        console.log("not found");
                        actor.updateOne({
                            _id: new ObjectId(from)
                        }, {
                            $push: {
                                "chats": {
                                    id: idchat
                                }
                            }
                        })
                        actor.updateOne({
                            _id: new ObjectId(to)
                        }, {
                            $push: {
                                "chats": {
                                    id: idchat
                                }
                            }
                        })
                        chat.insertOne({
                            id: idchat,
                            between: {
                                user1: from,
                                user2: to
                            },
                            messages: [{
                                from: from,
                                to: to,
                                content: content,
                                date: date,
                                time: time,
                                image: pic

                            }]

                        }, function (param) {
                            if (param)
                                io.to(to).emit("msgNumber", (from, content)

                                );
                            io.to(room).emit("outputS", [data]);



                            //send ststaus obj
                        });
                    }

                })
                /*if (test) {

                    chat.updateOne({
                        id: idchat
                    }, {
                        $push: {
                            messages: {
                                from: from,
                                to: to,
                                content: content,
                                date: date
                            }
                        }
                    }, (err, res) => {
                        if (err)
                            throw err;
                        io.emit("outputS", [data]);
                    });
                } else {
                    actor.updateOne({
                        _id: new ObjectId(from)
                    }, {
                        $push: {
                            "chats": {
                                id: idchat
                            }
                        }
                    })
                    actor.updateOne({
                        _id: new ObjectId(to)
                    }, {
                        $push: {
                            "chats": {
                                id: idchat
                            }
                        }
                    })
                    chat.insertOne({
                        id: idchat,
                        messages: [{
                            from: from,
                            to: to,
                            content: content,
                            date: date
                        }]

                    }, function (param) {
                        if (param)
                            throw param
                        io.emit("outputS", [data]);
                        //send ststaus obj
                    });
                }*/






            });


        });
    } catch (error) {
        console.error(error.message);
    }
})



server.listen(3000, () => {
    console.log("Server is running");
});
