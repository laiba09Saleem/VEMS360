<!-- Quick Book Modal -->
<div class="modal fade" id="quickBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quick Book Inquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="quickBookForm" method="POST" action="process_quickbook.php">
                    <!-- Quick book form content -->
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Venue Detail Modal -->
<div class="modal fade" id="venueDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Venue Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="venueModalContent">
                <!-- Content will be loaded dynamically via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#quickBookModal" data-bs-dismiss="modal">Book This Venue</button>
            </div>
        </div>
    </div>
</div>