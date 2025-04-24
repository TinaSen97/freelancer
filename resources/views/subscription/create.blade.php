@extends('layouts.app')

@section('content')
@if($plan)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Monthly Subscription') }}</div>

                <div class="card-body">
                    <form id="payment-form" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Selected Plan') }}</label>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $plan->name }}</h5>
                                        <p class="card-text">
                                            ₹{{ number_format($plan->price, 2) }} / month
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="card-holder-name" class="col-md-4 col-form-label text-md-right">{{ __('Card Holder Name') }}</label>
                            <div class="col-md-6">
                                <input id="card-holder-name" type="text" class="form-control @error('card_holder_name') is-invalid @enderror" name="card_holder_name" required autocomplete="off">
                                @error('card_holder_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Card Details') }}</label>
                            <div class="col-md-6">
                                <div id="card-element" class="form-control"></div>
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="submit-button">
                                    {{ __('Subscribe') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        displayError.textContent = event.error ? event.error.message : '';
    });

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const cardHolderName = document.getElementById('card-holder-name').value;

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: { name: cardHolderName }
        });

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            stripePaymentHandler(paymentMethod.id, cardHolderName);
        }
    });

    async function stripePaymentHandler(paymentMethodId, cardHolderName) {
        const submitButton = document.getElementById('submit-button');
        submitButton.disabled = true;

        try {
            const response = await fetch('{{ route("freelancer.subscription.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethodId,
                    card_holder_name: cardHolderName,
                    plan_id: '{{ $plan->id }}'
                })
            });

            const result = await response.json();

            if (result.error) {
                document.getElementById('card-errors').textContent = result.error;
                submitButton.disabled = false;
            } else {
                const { error } = await stripe.confirmCardPayment(result.client_secret);

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    submitButton.disabled = false;
                } else {
                    window.location.href = `/freelancer/subscription/${'{{ $plan->id }}'}`;
                }
            }
        } catch (error) {
            document.getElementById('card-errors').textContent = 'Payment processing failed. Please try again.';
            submitButton.disabled = false;
        }
    }
</script>
@endsection
@endif
@endsection
