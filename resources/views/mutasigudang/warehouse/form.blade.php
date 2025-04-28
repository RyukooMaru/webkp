<div class="form-group mb-3">
    <label>Nama Gudang</label>
    <input type="text" name="WARE_Name" class="form-control" value="{{ old('WARE_Name', $warehouse->WARE_Name ?? '') }}" required>
</div>

<div class="form-group mb-3">
    <label>Alamat</label>
    <input type="text" name="WARE_Address" class="form-control" value="{{ old('WARE_Address', $warehouse->WARE_Address ?? '') }}">
</div>

<div class="form-group mb-3">
    <label>Telepon</label>
    <input type="text" name="WARE_Phone" class="form-control" value="{{ old('WARE_Phone', $warehouse->WARE_Phone ?? '') }}">
</div>

<div class="form-group mb-3">
    <label>Fax</label>
    <input type="text" name="WARE_Fax" class="form-control" value="{{ old('WARE_Fax', $warehouse->WARE_Fax ?? '') }}">
</div>

<div class="form-group mb-3">
    <label>Email</label>
    <input type="email" name="WARE_Email" class="form-control" value="{{ old('WARE_Email', $warehouse->WARE_Email ?? '') }}">
</div>

<div class="form-group mb-3">
    <label>Website</label>
    <input type="text" name="WARE_Web" class="form-control" value="{{ old('WARE_Web', $warehouse->WARE_Web ?? '') }}">
</div>

<div class="form-group mb-3">
    <label>Catatan 1</label>
    <input type="text" name="ware_note1" class="form-control" value="{{ old('ware_note1', $warehouse->ware_note1 ?? '') }}">
</div>

<div class="form-group mb-3">
    <label>Catatan 2</label>
    <input type="text" name="ware_note2" class="form-control" value="{{ old('ware_note2', $warehouse->ware_note2 ?? '') }}">
</div>
