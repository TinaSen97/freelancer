<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    @include('admin.stylesheet')
</head>

<body>

@include('admin.navigation')

@if(in_array('subscription',$avilable))
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pending KYC Verifications</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Freelancer</th>
                            <th>ID Document</th>
                            <th>Address Proof</th>
                            <th>Biometric Photo</th>
                            <th>Signature</th>
                            <th>Submitted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($freelancers as $freelancer)
                        <tr>
                            <td>{{ $freelancer->name }}<br>{{ $freelancer->email }}</td>
                            
                            <!-- Government ID -->
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary view-doc-btn"
                                    data-url="{{ route('admin.kyc-show', ['id' => $freelancer->id, 'type' => 'government_id']) }}"
                                    data-toggle="modal" data-target="#kycModal">
                                    View Government ID
                                </button>
                            </td>
                            
                            <!-- Address Proof -->
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary view-doc-btn"
                                    data-url="{{ route('admin.kyc-show', ['id' => $freelancer->id, 'type' => 'address_proof']) }}"
                                    data-toggle="modal" data-target="#kycModal">
                                    View Address Proof
                                </button>
                            </td>
                            
                            <!-- Biometric Photo -->
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary view-doc-btn"
                                    data-url="{{ route('admin.kyc-show', ['id' => $freelancer->id, 'type' => 'biometric_photo']) }}"
                                    data-toggle="modal" data-target="#kycModal">
                                    View Biometric Photo
                                </button>
                            </td>
                            
                            <!-- Signature -->
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary view-doc-btn"
                                    data-url="{{ route('admin.kyc-show', ['id' => $freelancer->id, 'type' => 'signature']) }}"
                                    data-toggle="modal" data-target="#kycModal">
                                    View Signature
                                </button>
                            </td>

                            <td>{{ $freelancer->kyc_verified_at?->format('d M Y H:i') }}</td>
                            
                            <td class="d-flex gap-2">
                                <form action="{{ url('/admin/kyc/' . $freelancer->id . '/approve') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form action="{{ url('/admin/kyc/' . $freelancer->id . '/reject') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No pending KYC verifications</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $freelancers->links() }}
            </div>
        </div>
    </div>
</div>

<!-- KYC Document Modal -->
<div class="modal fade" id="kycModal" tabindex="-1" aria-labelledby="kycModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">KYC Document Viewer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" id="kycModalBody">
                <p>Loading document...</p>
            </div>
        </div>
    </div>
</div>

@else
    @include('admin.denied')
@endif

@include('admin.javascript')

<!-- JavaScript to preview documents in modal -->
<script>
    $(document).ready(function () {
        $('.view-doc-btn').on('click', function () {
            const docUrl = $(this).data('url');
            const $modalBody = $('#kycModalBody');
            $modalBody.html('<p>Loading document...</p>');

            // Try loading as image
            const img = new Image();
            img.src = docUrl;
            img.className = "img-fluid";
            img.alt = "KYC Document";

            img.onload = function () {
                $modalBody.html(img);
            };

            img.onerror = function () {
                // If image fails to load, try loading as PDF
                $modalBody.html(
                    `<iframe src="${docUrl}" width="100%" height="600px" style="border:none;"></iframe>`
                );
            };
        });
    });
</script>


</body>
</html>
