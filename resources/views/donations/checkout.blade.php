@extends('layouts.app')

@section('title', 'Secure Checkout | HFRO')

@push('styles')
<style>
    .rounded-bento { border-radius: 24px; }
    .fw-black { font-weight: 900; }
    .form-label-small { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--primary-color); letter-spacing: 1px; }
    .form-control-premium { background: #f8f9fa; border: 2px solid transparent; border-radius: 12px; padding: 12px 18px; transition: 0.3s; width: 100%; }
    .form-control-premium:focus { border-color: var(--primary-color); background: #fff; outline: none; }
    
    .btn-outline-premium { border: 2px solid #eee; border-radius: 12px; font-weight: 700; color: #666; transition: 0.3s; }
    .btn-check:checked + .btn-outline-premium { border-color: var(--primary-color); background: var(--bg-soft-purple); color: var(--primary-color); }

    /* Payment Method Cards */
    .payment-methods-grid { display: grid; gap: 12px; }
    .method-card { cursor: pointer; position: relative; }
    .method-card input { position: absolute; opacity: 0; }
    .method-content { border: 2px solid #eee; border-radius: 15px; padding: 20px; display: flex; align-items: center; transition: 0.3s; }
    .method-card input:checked + .method-content { border-color: var(--primary-color); background: rgba(45, 13, 82, 0.02); }

    .bg-soft-success { background: #e6f7ef; }
    .x-small { font-size: 0.75rem; }
</style>
@endpush

@section('content')
<div class="container-fluid bg-light min-vh-100 py-5">
    <div class="container mt-5">
        <div class="row g-5 justify-content-center">
            
            <div class="col-lg-7">
                <div class="bg-white p-5 rounded-bento shadow-premium border-0">
                    <div class="d-flex align-items-center mb-5">
                        <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <i class="fas fa-lock small"></i>
                        </div>
                        <h3 class="fw-black text-purple mb-0">Secure Donation</h3>
                    </div>

                    <form action="#" method="POST" id="payment-form">
                        @csrf
                        
                        <div class="mb-5">
                            <label class="form-label-small mb-3">Confirm Amount (USD)</label>
                            <div class="row g-2">
                                <div class="col-3"><input type="radio" class="btn-check" name="amount" id="amt1" value="25"><label class="btn btn-outline-premium w-100 py-3" for="amt1">$25</label></div>
                                <div class="col-3"><input type="radio" class="btn-check" name="amount" id="amt2" value="50" checked><label class="btn btn-outline-premium w-100 py-3" for="amt2">$50</label></div>
                                <div class="col-3"><input type="radio" class="btn-check" name="amount" id="amt3" value="100"><label class="btn btn-outline-premium w-100 py-3" for="amt3">$100</label></div>
                                <div class="col-3"><input type="text" class="form-control-premium text-center" placeholder="Other"></div>
                            </div>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-12"><label class="form-label-small">Full Name</label><input type="text" class="form-control-premium" placeholder="John Doe" required></div>
                            <div class="col-12"><label class="form-label-small">Email Address</label><input type="email" class="form-control-premium" placeholder="john@example.com" required></div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label-small mb-3">Select Payment Method</label>
                            <div class="payment-methods-grid">
                                <label class="method-card">
                                    <input type="radio" name="method" value="momo" checked>
                                    <div class="method-content">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/MTN_Logo.svg" alt="MTN" style="height: 20px;">
                                        <span class="fw-bold ms-2">Mobile Money</span>
                                    </div>
                                </label>
                                <label class="method-card">
                                    <input type="radio" name="method" value="card">
                                    <div class="method-content">
                                        <i class="fas fa-credit-card text-primary"></i>
                                        <span class="fw-bold ms-2">Credit/Debit Card</span>
                                    </div>
                                </label>
                                <label class="method-card">
                                    <input type="radio" name="method" value="paypal">
                                    <div class="method-content">
                                        <i class="fab fa-paypal text-info"></i>
                                        <span class="fw-bold ms-2">PayPal</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-purple-gradient w-100 py-4 rounded-pill fw-black shadow-lg text-uppercase tracking-wider">
                            Complete Donation
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" height="20" class="mx-2 opacity-50">
                        <img src="https://www.visa.com.rw/dam/VCOM/regional/ve/romania/blogs/images/visa-logo-800x450.jpg" height="20" class="mx-2 opacity-50">
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 120px;">
                    <div class="card border-0 rounded-bento shadow-sm overflow-hidden mb-4">
                        <div class="p-4 bg-purple text-white">
                            <h5 class="fw-bold mb-0">Your Impact</h5>
                        </div>
                        <div class="p-4 bg-white">
                            <div class="d-flex mb-3">
                                <img src="{{ asset('storage/projects/school.jpg') }}" class="rounded-3 me-3" style="width: 80px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="fw-bold mb-1 small">Vocational Toolkits</h6>
                                    <p class="x-small text-muted mb-0">Education Project</p>
                                </div>
                            </div>
                            <hr class="opacity-10">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Donation Amount</span>
                                <span class="fw-bold text-dark">$50.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-muted small">Processing Fee (Covered)</span>
                                <span class="text-success small fw-bold">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-3">
                                <h5 class="fw-black text-purple">Total</h5>
                                <h5 class="fw-black text-purple">$50.00</h5>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-3 rounded-4 bg-soft-success border-0 d-flex align-items-start">
                        <i class="fas fa-check-circle text-success mt-1 me-2"></i>
                        <p class="x-small text-success mb-0 fw-bold">
                            Your donation is tax-deductible in Rwanda. A receipt will be sent to your email instantly.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    const paymentForm = document.getElementById('payment-form');
    
    paymentForm.addEventListener("submit", function(e) {
        e.preventDefault();

        // 1. Get Values
        const amount = document.querySelector('input[name="amount"]:checked').value;
        const email = document.getElementById('email').value;
        const fullName = document.getElementById('full_name').value;

        // 2. Initialize Paystack
        let handler = PaystackPop.setup({
            key: '{{ config("services.paystack.public_key") }}', // We will set this in .env
            email: email,
            amount: amount * 100 * 1300, // Conversion: $ Amount * 100 (kobo/cents) * Exchange Rate (e.g. 1300 RWF)
            currency: 'RWF', // Use RWF for Momo support in Rwanda
            ref: 'HFRO_'+Math.floor((Math.random() * 1000000000) + 1), // Generate unique ref
            metadata: {
                custom_fields: [
                    {
                        display_name: "Donor Name",
                        variable_name: "donor_name",
                        value: fullName
                    },
                    {
                        display_name: "Project",
                        variable_name: "project",
                        value: "Vocational Toolkits" // Pass your project title here
                    }
                ]
            },
            callback: function(response){
                // This runs when payment is successful
                window.location.href = "/donation/success?reference=" + response.reference;
            },
            onClose: function(){
                alert('Transaction was not completed. Your support still matters to us!');
            }
        });

        handler.openIframe();
    });
</script>
@endpush

@endsection