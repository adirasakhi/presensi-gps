@extends('layouts.sidebar')
@section('title', 'Perizinan')
@section('container')
<style>
    /* Global style */


.btn-tertiary {
  color: #555;
  padding: 0;
  line-height: 40px;
  width: 300px;
  margin: auto;
  display: block;
  border: 2px solid #555;
  &:hover,
    &:focus {
      color: lighten(#555, 20%);
      border-color: lighten(#555, 20%);
    }
}

/* input file style */

.input-file {
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	position: absolute;
	z-index: -1;
  + .js-labelFile {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding: 0 10px;
    cursor: pointer;
    .icon:before {
      //font-awesome
      content: "\f093";
    }
    &.has-file {
      .icon:before {
        //font-awesome
        content: "\f00c";
        color: #5AAC7B;
      }
    }
  }
}
</style>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Profile</h1>

    <div class="d-flex justify-content-center">
        <div class="card d-flex justify-content-center" style="width: 500px;">
            <div class="card-body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <center><h2>Isi Data Di Bawah</h2></center>
                <div class="form-group">
                    <input type="file" name="izin" id="izin" class="input-file">
                    <label for="izin" class="btn btn-tertiary js-labelFile">
                      <i class="icon fa fa-check"></i>
                      <span class="js-fileName">Surat Izin Masuk Site</span>
                    </label>
                  </div>
                  <div class="form-group">
                    <input type="file" name="kendaraan" id="kendaraan" class="input-file">
                    <label for="kendaraan" class="btn btn-tertiary js-labelFile">
                      <i class="icon fa fa-check"></i>
                      <span class="js-fileName">Foto Kendaraan</span>
                    </label>
                  </div>
                  <center><button type="submit" class="btn btn-danger">Kirim</button></center>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    (function() {

  'use strict';

  $('.input-file').each(function() {
    var $input = $(this),
        $label = $input.next('.js-labelFile'),
        labelVal = $label.html();

   $input.on('change', function(element) {
      var fileName = '';
      if (element.target.value) fileName = element.target.value.split('\\').pop();
      fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);
   });
  });

})();
</script>
@include('layouts.script')
@endsection
