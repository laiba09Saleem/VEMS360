<?php
require_once 'config/config.php';
require_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/logo.png">
    <title><?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<!-- Hero Section -->
<header class="hero-section" id="home">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center text-white">
                <h1 class="display-4 fw-bold mb-4">Your Perfect Event, Our Expertise</h1>
                <p class="lead mb-4">From virtual meetings to grand weddings - we've got you covered across Pakistan</p>
                <div class="d-flex justify-content-center flex-wrap gap-3">
                    <a href="#venues" class="btn btn-primary btn-lg px-4">Explore Venues</a>
                    <a href="#event-types" class="btn btn-outline-light btn-lg px-4">Virtual Events</a>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="search-section py-4 bg-light">
    <div class="container">
        <form id="searchForm">
            <div class="row g-3">
                <div class="col-md-3">
                    <select class="form-select" name="event_type" required>
                        <option value="" selected disabled>Event Type</option>
                        <option value="wedding">Wedding</option>
                        <option value="corporate">Corporate Meeting</option>
                        <option value="birthday">Birthday Party</option>
                        <option value="conference">Conference</option>
                        <option value="exhibition">Exhibition</option>
                        <option value="virtual">Virtual Event</option>
                        <option value="hybrid">Hybrid Event</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="location" required>
                        <option value="" selected disabled>Location</option>
                        <option value="karachi">Karachi</option>
                        <option value="lahore">Lahore</option>
                        <option value="islamabad">Islamabad</option>
                        <option value="rawalpindi">Rawalpindi</option>
                        <option value="peshawar">Peshawar</option>
                        <option value="quetta">Quetta</option>
                        <option value="faisalabad">Faisalabad</option>
                        <option value="multan">Multan</option>
                        <option value="online">Online/Virtual</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="event_date" required>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="budget_range">
                        <option value="" selected disabled>Budget Range</option>
                        <option value="0-50000">Under Rs. 50,000</option>
                        <option value="50000-200000">Rs. 50,000 - 200,000</option>
                        <option value="200000-500000">Rs. 200,000 - 500,000</option>
                        <option value="500000-1000000">Rs. 500,000 - 1,000,000</option>
                        <option value="1000000+">Over Rs. 1,000,000</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="py-5" id="event-types">
    <div class="container">
        <div class="section-header mb-5 text-center">
            <h2 class="fw-bold">Our Event Solutions</h2>
            <p class="text-muted">Choose the perfect format for your event</p>
        </div>
        
        <ul class="nav nav-tabs event-type-tabs justify-content-center mb-4" id="eventTypeTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="physical-tab" data-bs-toggle="tab" data-bs-target="#physical" type="button" role="tab">Physical Events</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="virtual-tab" data-bs-toggle="tab" data-bs-target="#virtual" type="button" role="tab">Virtual Events</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hybrid-tab" data-bs-toggle="tab" data-bs-target="#hybrid" type="button" role="tab">Hybrid Events</button>
            </li>
        </ul>
        
        <div class="tab-content" id="eventTypeTabsContent">
            <div class="tab-pane fade show active" id="physical" role="tabpanel">
                <?php include 'includes/event-types/physical.php'; ?>
            </div>
            
            <div class="tab-pane fade" id="virtual" role="tabpanel">
                <?php include 'includes/event-types/virtual.php'; ?>
            </div>
            
            <div class="tab-pane fade" id="hybrid" role="tabpanel">
                <?php include 'includes/event-types/hybrid.php'; ?>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light" id="venues">
    <?php include 'includes/featured-venues.php'; ?>
</section>

<section class="py-5" id="services">
    <?php include 'includes/services.php'; ?>
</section>

<section class="py-5 bg-light">
    <?php include 'includes/budget-options.php'; ?>
</section>

<section class="py-5">
    <?php include 'includes/testimonials.php'; ?>
</section>

<section class="py-5 bg-light" id="about">
    <?php include 'includes/about.php'; ?>
</section>

<section class="py-5" id="contact">
    <?php include 'includes/contact.php'; ?>
</section>

<?php
require_once 'includes/footer.php';
?>