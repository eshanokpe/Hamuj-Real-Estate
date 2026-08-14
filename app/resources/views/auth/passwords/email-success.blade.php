@extends('layouts.app')

@section('content')
    <section class="account__page--section section--padding">
        <div class="container">
            <div class="account__section--inner">
                <div class="account__form--wrapper" style="max-width: 560px; margin: 0 auto;">
                    <div class="account__header text-center mb-30">
                        <div style="width: 72px; height: 72px; margin: 0 auto 20px; border-radius: 50%; background: rgba(62, 180, 137, 0.12); display: flex; align-items: center; justify-content: center; font-size: 32px;">
                            ✓
                        </div>
                        <h2 class="account__title">Password reset link sent</h2>
                    </div>

                    <div class="account__form">
                        <div class="text-center" style="padding: 24px 20px; border-radius: 16px; background: #f8fafc; border: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 16px; line-height: 1.6; color: #1f2937;">
                                {{ $message ?? 'If an account exists with this email, you will receive a reset link shortly.' }}
                            </p>
                        </div>

                        <div class="text-center mt-30">
                            <a href="{{ route('login') }}" class="account__form--btn solid__btn" style="display: inline-block; text-decoration: none;">
                                Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
