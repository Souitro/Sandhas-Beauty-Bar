<?php
require 'db.php';

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_booking'])) {
    $name    = trim($_POST['name']);
    $phone   = trim($_POST['phone']);
    $email   = trim($_POST['email']);
    $service = trim($_POST['service']);
    $date    = $_POST['date'];
    $time    = $_POST['time'];
    $notes   = trim($_POST['notes']);
    $status  = 'pending';

    // Get service_id from service name
    $stmt = $conn->prepare("SELECT id FROM services WHERE name = ?");
    $stmt->bind_param("s", $service);
    $stmt->execute();
    $stmt->bind_result($service_id);
    $stmt->fetch();
    $stmt->close();

    if (!$service_id) {
        $feedback = "<p style='color:red;'>Invalid service selected.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (name, phone, email, service_id, date, time, notes, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssissss", $name, $phone, $email, $service_id, $date, $time, $notes, $status);
            $stmt->execute();
            $stmt->close();
            $feedback = "<p style='color:green;'>Booking submitted successfully!</p>";
        } else {
            $feedback = "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}
?>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Book Appointment</h2>
                <a href="#" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <div class="icon-x text-xl"></div>
                </a>
            </div>

            <?php if (isset($feedback)) echo $feedback; ?>

            <form method="POST" class="space-y-4">
                <input type="hidden" name="submit_booking" value="1">

                <h4 style="text-align:center; color: red;">
                    <b style="color:black;">Note:</b> To Join Membership, please use the contact details on a contact section, for quick response. Thank you!
                </h4>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Full Name *</label>
                        <input type="text" name="name" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Phone Number *</label>
                        <input type="tel" name="phone" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Email Address *</label>
                    <input type="email" name="email" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Service *</label>
                    <select name="service" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                        <option value="">Select a service</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= htmlspecialchars($service['name']) ?>">
                                <?= htmlspecialchars($service['name']) ?> - R<?= htmlspecialchars($service['price']) ?> (<?= htmlspecialchars($service['duration']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Preferred Date *</label>
                        <input type="date" name="date" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Preferred Time *</label>
                        <select name="time" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]">
                            <option value="">Select time</option>
                            <?php foreach ($TIME_SLOTS as $slot): ?>
                                <option value="<?= $slot ?>"><?= $slot ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Additional Notes</label>
                    <textarea name="notes" rows="3" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[var(--primary-color)]" placeholder="Any special requests or preferences..."></textarea>
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="#" onclick="closeModal()" class="flex-1 btn-secondary text-center">Cancel</a>
                    <button type="submit" class="flex-1 btn-primary">Book Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('bookingModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('bookingModal').classList.add('hidden');
}
</script>