@extends('welcome')
@section('content')

<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title text-center">Contact <strong>Us</strong></h2>
                <div id="gmap" class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3835.2712719853794!2d108.21180227490251!3d15.999387984670001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31421a157e056679%3A0x9a2374f8e28c29f5!2zMiBM4buXIEdpw6FuZyAxMSwgSG_DoCBYdcOibiwgQ-G6qW0gTOG7hywgxJDDoCBO4bq1bmcgNTUwMDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1717344410230!5m2!1svi!2s" width="1000" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="contact-form">
                    <h2 class="title text-center">Get In Touch</h2>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form id="main-contact-form" class="contact-form row" name="contact-form" method="post" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="form-group col-md-6">
                            <input type="email" name="email" class="form-control" required="required" placeholder="Email">
                        </div>
                        <div class="form-group col-md-12">
                            <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Your Message Here"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" name="submit" class="btn btn-primary pull-right" value="Gửi comment">
                        </div>
                    </form>
                </div>
                <div class="comments">
                    <h2 class="title text-center">Comments</h2>
                    @foreach($contacts as $contact)
                        <div class="comment">
                            <p><strong>Email:</strong> {{ $contact->email }}</p>
                            <p><strong>Message:</strong> {{ $contact->message }}</p>
                            <p><em>{{ $contact->created_at }}</em></p>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div><!--/#contact-page-->

@endsection
