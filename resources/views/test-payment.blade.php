@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="col-md-10">

            @if(session('msg'))
                <div class="alert alert-success" role="alert">
                    {{ session('msg') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                @foreach ($plans as $plan)
                    <form action="{{ route('pay', $plan->id) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="col-sm-5 col-md-5">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h3>{{ $plan->name }}</h3>
                                    <p>{{ $plan->description }}</p>
                                    <p>Buy for ${{ $plan->amount }}</p>
                                    <p>
                                        <script
                                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                data-key="{{ env('STRIPE_KEY') }}"
                                                data-amount="{{ $plan->amount * 100 }}"
                                                data-name="Stripe.com"
                                                data-description="Widget"
                                                data-locale="auto"
                                                data-currency="usd">
                                        </script>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>

        </div>
    </div>

@endsection