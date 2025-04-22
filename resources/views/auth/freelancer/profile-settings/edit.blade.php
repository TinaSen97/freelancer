    @extends('layouts.app')

    @section('content')
    <div class="page-title-overlap pt-4" style="background-image: url('{{ url('/') }}/public/storage/settings/{{ $allsettings->site_banner }}');">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-star">
                        <li class="breadcrumb-item"><a class="text-nowrap" href="{{ URL::to('/') }}"><i class="dwg-home"></i>{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ __('Profile Settings') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                <h1 class="h3 mb-0 text-white">{{ __('Profile Settings') }}</h1>
            </div>
        </div>
    </div>

    <div class="container pb-5 mb-2 mb-md-3">
        <div class="row">
            <aside class="col-lg-4 pt-5 mt-3">
                <div class="d-block d-lg-none p-4">
                    <a class="btn btn-outline-accent d-block" href="#account-menu" data-toggle="collapse"><i class="dwg-menu mr-2"></i>{{ __('Account menu') }}</a>
                </div>
                @include('auth.freelancer.freelancer-dashboard-menu')
            </aside>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">Profile Settings</div>
                    <div class="card-body">
                        <form id="freelancer-settings-form" method="POST" action="{{ route('freelancer.profile-settings.update') }}" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <!-- Personal Details -->
                            <div class="pt-4">
                                <h5>Personal Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload Section -->
                            <div class="border-top pt-4">
                                <h5>Image Upload Section</h5>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="avatar-upload">
                                            <label class="form-label">{{ __('Profile Image') }} (100x100 px)</label>
                                            <div class="avatar-edit">
                                                <input type="file" id="profile-picture" name="image" accept=".png, .jpg, .jpeg" class="form-control" data-upload-url="{{ route('freelancer.profile-settings.upload-image') }}" data-type="profile">
                                                <small class="form-text text-muted">Max 2MB (PNG, JPG, JPEG)</small>
                                            </div>
                                            <div class="avatar-preview">
                                                <img  height="100px" src="{{ $user->profile_picture ? asset('public/uploads/freelancers/profiles/' . basename($user->profile_picture)) : asset('public/assets/images/usr_avatar.png') }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="cover-upload">
                                            <label class="form-label">{{ __('Cover Image') }} (750x370 px)</label>
                                            <div class="cover-edit">
                                                <input type="file" id="cover-photo" name="cover_photo" accept=".png, .jpg, .jpeg" class="form-control" data-upload-url="{{ route('freelancer.profile-settings.upload-image') }}" data-type="cover">
                                                <small class="form-text text-muted">Max 2MB (PNG, JPG, JPEG)</small>
                                            </div>
                                            <div class="cover-preview">
                                                <img  height="100px"  src="{{ $user->cover_photo ? asset('public/uploads/freelancers/covers/' . basename($user->cover_photo)) : asset('public/assets/images/usr_avatar.png') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Professional Details -->
                            <div class="border-top pt-4">
                                <h5>Professional Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="skills" class="form-label">Skills <span class="text-danger">*</span></label>
                                        <input id="skills" type="text" class="form-control @error('skills') is-invalid @enderror" name="skills" value="{{ old('skills', $user->skills) }}" required>
                                        @error('skills') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="experience" class="form-label">Experience (Years) <span class="text-danger">*</span></label>
                                        <input id="experience" type="number" min="1" class="form-control @error('experience') is-invalid @enderror" name="experience" value="{{ old('experience', $user->experience) }}" required>
                                        @error('experience') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Portfolio & Bio -->
                            <div class="border-top pt-4">
                            <h5>Portfolio & Bio</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="facebook_url" class="form-label">Facebook URL</label>
                                    <input type="url" id="facebook_url" name="facebook_url"
                                        class="form-control @error('facebook_url') is-invalid @enderror"
                                        value="{{ old('facebook_url', $user->facebook_url) }}"
                                        placeholder="https://facebook.com/your-profile">
                                    @error('facebook_url') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="twitter_url" class="form-label">Twitter URL</label>
                                    <input type="url" id="twitter_url" name="twitter_url"
                                        class="form-control @error('twitter_url') is-invalid @enderror"
                                        value="{{ old('twitter_url', $user->twitter_url) }}"
                                        placeholder="https://twitter.com/your-handle">
                                    @error('twitter_url') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="instagram_url" class="form-label">Instagram URL</label>
                                    <input type="url" id="instagram_url" name="instagram_url"
                                        class="form-control @error('instagram_url') is-invalid @enderror"
                                        value="{{ old('instagram_url', $user->instagram_url) }}"
                                        placeholder="https://instagram.com/your-handle">
                                    @error('instagram_url') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                    <input type="url" id="linkedin_url" name="linkedin_url"
                                        class="form-control @error('linkedin_url') is-invalid @enderror"
                                        value="{{ old('linkedin_url', $user->linkedin_url) }}"
                                        placeholder="https://linkedin.com/in/your-profile">
                                    @error('linkedin_url') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="pinterest_url" class="form-label">Pinterest URL</label>
                                    <input type="url" id="pinterest_url" name="pinterest_url"
                                        class="form-control @error('pinterest_url') is-invalid @enderror"
                                        value="{{ old('pinterest_url', $user->pinterest_url) }}"
                                        placeholder="https://pinterest.com/your-profile">
                                    @error('pinterest_url') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="bio" class="form-label">Professional Bio <span class="text-danger">*</span></label>
                                    <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="5" required
                                            placeholder="Briefly describe your professional background, skills, and experience.">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Verification Documents -->
                        <div class="border-top pt-4">
                            <h5>Verification Documents</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="government_id" class="form-label">Government ID <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('government_id') is-invalid @enderror" id="government_id" name="government_id" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <small class="form-text text-muted">Upload a clear scan of your government-issued ID</small>
                                    @error('government_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    <div class="avatar-preview">
                                        <!-- <img width="50px" height="50px" src="{{ $user->government_id_path ? asset($user->government_id_path)  : asset('public/assets/images/usr_avatar.png') }}" /> -->
                                        <img src="{{ route('freelancer.document.show', ['id' => $user->id, 'type' => 'government_id']) }}" width="100">

                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <label for="address_proof" class="form-label">Address Proof <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('address_proof') is-invalid @enderror" id="address_proof" name="address_proof" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <small class="form-text text-muted">Recent utility bill or bank statement</small>
                                    @error('address_proof') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    <div class="avatar-preview">
                                        <img src="{{ route('freelancer.document.show', ['id' => $user->id, 'type' => 'address_proof']) }}" width="100">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="biometric_photo" class="form-label">Biometric Photo <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('biometric_photo') is-invalid @enderror" id="biometric_photo" name="biometric_photo" accept=".jpg,.jpeg,.png" required>
                                    <small class="form-text text-muted">Recent passport-style photo</small>
                                    @error('biometric_photo') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    <div class="avatar-preview">
                                        <img src="{{ route('freelancer.document.show', ['id' => $user->id, 'type' => 'biometric_photo']) }}" width="100">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Signature <span class="text-danger">*</span></label>
                                    <canvas id="signature-pad"></canvas>
                                    <input type="hidden" name="signature_data" id="signature-data">
                                    <div class="avatar-preview">
                                        <img src="{{ route('freelancer.document.show', ['id' => $user->id, 'type' => 'signature']) }}" >
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="clearSignature()">Clear</button>
                                </div>
                            </div>
                        </div>


                            <!-- Security Section -->
                            <div class="border-top pt-4">
                                <h5>Security Settings</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">New Password</label>
                                        <input id="password" type="password" minlength="6"
                                            class="form-control @error('password') is-invalid @enderror" name="password">
                                        @error('password') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password-confirm" class="form-label">Confirm Password</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="button" id="validate-and-submit" class="btn btn-primary mt-3">Save All Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    <style>
    .avatar-preview, .cover-preview {
        width: 50%;
        height: 100px;
        background-size: cover;
        background-position: center;
        border: 2px dashed #ddd;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .avatar-preview img, .cover-preview img {
        max-height: 100%;
        max-width: 100%;
    }

    /* Signature canvas responsive */
    #signature-pad {
        width: 100%;
        height: 100px;
        border: 1px solid #ddd;
        background: white;
        cursor: crosshair;
    }
    </style>

    <script src="https://cdn.tiny.cloud/1/your-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('freelancer-settings-form');
        const submitBtn = document.getElementById('validate-and-submit');

        // FORM VALIDATION
        function clearErrors() {
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        }

        function showError(input, message) {
            input.classList.add('is-invalid');
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = message;
            input.parentNode.appendChild(feedback);
        }

        function validateForm() {
            clearErrors();
            let isValid = true;

            const name = form.querySelector('#name');
            const email = form.querySelector('#email');
            const skills = form.querySelector('#skills');
            const experience = form.querySelector('#experience');
            const bio = form.querySelector('#bio');
            const password = form.querySelector('#password');
            const confirmPassword = form.querySelector('#password-confirm');

            if (!name.value.trim()) {
                showError(name, 'Full Name is required.');
                isValid = false;
            }

            if (!email.value.trim()) {
                showError(email, 'Email is required.');
                isValid = false;
            } else if (!/^\S+@\S+\.\S+$/.test(email.value)) {
                showError(email, 'Enter a valid email address.');
                isValid = false;
            }

            if (!skills.value.trim()) {
                showError(skills, 'Skills are required.');
                isValid = false;
            }

            if (!experience.value.trim() || parseInt(experience.value) < 1) {
                showError(experience, 'Experience must be at least 1 year.');
                isValid = false;
            }

            if (!bio.value.trim()) {
                showError(bio, 'Bio is required.');
                isValid = false;
            }

            if (password.value || confirmPassword.value) {
                if (password.value.length < 6) {
                    showError(password, 'Password must be at least 6 characters.');
                    isValid = false;
                }
                if (password.value !== confirmPassword.value) {
                    showError(confirmPassword, 'Passwords do not match.');
                    isValid = false;
                }
            }

            return isValid;
        }

        submitBtn.addEventListener('click', function () {
            if (validateForm()) {
                form.submit();
            }
        });

        // IMAGE UPLOAD PREVIEW
        function uploadImage(input) {
            const file = input.files[0];
            const url = input.dataset.uploadUrl;
            const type = input.dataset.type;

            if (!file || !url || !type) return;

            const formData = new FormData();
            formData.append('image', file);
            formData.append('type', type);
            formData.append('_token', '{{ csrf_token() }}');

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(async (res) => {
                const data = await res.json();
                if (data.status === 'success') {
                    const preview = input.closest('.col-md-6').querySelector('.avatar-preview img, .cover-preview img');
                    if (preview) {
                        preview.src = data.url + '?t=' + new Date().getTime(); // prevent caching
                    }
                } else {
                    alert(data.message || 'Upload failed.');
                }
            })
            .catch((err) => {
                console.error(err);
                alert('An error occurred during upload.');
            });
        }

        document.querySelectorAll('input[type="file"][data-upload-url]').forEach(input => {
            input.addEventListener('change', function () {
                uploadImage(this);
            });
        });

        // SIGNATURE PAD SETUP
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas);

        // Resize for high DPI screens
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext('2d').scale(ratio, ratio);
            signaturePad.clear(); // clear old drawing
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        // Save signature data
        signaturePad.onEnd = function () {
            document.getElementById('signature-data').value = signaturePad.toDataURL();
        };

        // Clear button functionality
        window.clearSignature = function () {
            signaturePad.clear();
            document.getElementById('signature-data').value = '';
        };
    });
    </script>

