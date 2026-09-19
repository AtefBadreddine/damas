<input type="hidden" id="lat" name="latitude" value="<?= $row->latitude; ?>"/>
<input type="hidden" id="lng" name="longitude" value="<?= $row->longitude; ?>" />
<div id="map" style="height:320px;width:100%"></div>
@section('scriptjs')
<script src='https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCro2ODdWVQ3owh4yopDw3xI8qagCkPpKU&sensor=false' type="text/javascript"></script>
<script src="<?= asset('admin/js/script_maps.js'); ?>"></script>
<script>
    google.maps.event.addDomListener(window, 'load', initMap);
</script>
@endsection 