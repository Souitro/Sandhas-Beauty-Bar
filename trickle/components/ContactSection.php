<?php
// contact-section.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Example: send email (replace with PHPMailer for production)
    $to = "info@Sandha.beautybar.com";
    $headers = "From: $email\r\nReply-To: $email\r\n";
    $fullMessage = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    mail($to, $subject, $fullMessage, $headers);

    echo "<script>alert('Message sent! We will get back to you soon.');</script>";
}
?>

<section id="contact" class="section-padding bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Get In Touch</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div>
                <h3 class="text-2xl font-bold mb-8">Contact Information</h3>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[var(--primary-color)] rounded-lg flex items-center justify-center">
                            <div class="icon-map-pin text-xl text-white"></div>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-1">Address</h4>
                            <p class="text-gray-600">123 Beauty Street<br />Share, SA 10001</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[var(--primary-color)] rounded-lg flex items-center justify-center">
                            <div class="icon-phone text-xl text-white"></div>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-1">Phone</h4>
                            <p class="text-gray-600"><a href="tel:0790391480">(+27) 79 039 1480</a></p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[var(--primary-color)] rounded-lg flex items-center justify-center">
                            <div class="icon-mail text-xl text-white"></div>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-1">Email</h4>
                            <p class="text-gray-600"><a href="mailto:info@Sandha.beautybar.com">info@Sandha.beautybar.com</a></p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[var(--primary-color)] rounded-lg flex items-center justify-center">
                            <div class="icon-clock text-xl text-white"></div>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-1">Business Hours</h4>
                            <p class="text-gray-600">
                                Mon - Fri: 9:00 AM - 6:00 PM<br />
                                Saturday: 9:00 AM - 5:00 PM<br />
                                Sunday: Closed
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div>
                <h3 class="text-2xl font-bold mb-8">Send Message</h3>
                <form method="POST" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Name *</label>
                            <input type="text" name="name" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Email *</label>
                            <input type="email" name="email" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Subject *</label>
                        <input type="text" name="subject" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Message *</label>
                        <textarea name="message" rows="5" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]"></textarea>
                    </div>

                    <button type="submit" class="w-full btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>