<?php
session_start();
require('connect.php');
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>About Us</title>
</head>
<body>
<section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100" style="max-width: 900px;">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-10">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h1 class="text-center mb-4">ABOUT US</h1>
                            <p class="text-justify mb-4">
                                Welcome to Football Legends, your number one source for all things related to the greatest footballers of all time. We’re dedicated to providing you with the most comprehensive and engaging content, with a focus on the legendary careers, iconic moments, and lasting legacies of football’s biggest stars.
                            </p>
                            <p class="text-justify mb-4">
                                Founded in 2023, Football Legends has come a long way from its beginnings. When we first started out, our passion for football and its history drove us to start this blog.
                            </p>
                            <p class="text-justify mb-4">
                                We aim to serve football fans around the world and are thrilled that we’re able to turn our passion into this website. Our team is committed to researching and delivering high-quality content that respects the rich history of the sport and honors the players who have made it what it is today.
                            </p>
                            <p class="text-justify mb-4">
                                On our website, you’ll find detailed biographies, career highlights, memorable matches, and much more about football legends from Pelé to Messi, Maradona to Ronaldo, and many more. We strive to create a platform where the past and present of football can be celebrated and explored in depth.
                            </p>
                            <p class="text-justify mb-4">
                                We hope you enjoy our content as much as we enjoy offering it to you. If you have any questions or comments, please don’t hesitate to contact us.
                            </p>
                            <p class="text-center font-italic">Sincerely, T.O Blog Team</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<h2 class="text-center mt-5">CONTACT US</h2>
<form style="max-width: 600px; margin: 0 auto;">
    <!-- Name input -->
    <div class="form-outline mb-4">
        <input type="text" id="form4Example1" class="form-control" placeholder="Your Name" required />
    </div>

    <!-- Email input -->
    <div class="form-outline mb-4">
        <input type="email" id="form4Example2" class="form-control" placeholder="Your Email Address" required />
    </div>

    <!-- Message input -->
    <div class="form-outline mb-4">
        <textarea class="form-control" id="form4Example3" rows="4" placeholder="Your Message" required></textarea>
    </div>

    <!-- Checkbox -->
    <div class="form-check d-flex justify-content-center mb-4">
        <input class="form-check-input me-2" type="checkbox" id="form4Example4" checked />
        <label class="form-check-label" for="form4Example4">
            Send me a copy of this message
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" class="btn btn-success btn-block">Send</button>
</form>

    <?php include 'footer.php'; ?>
</body>
</html>
