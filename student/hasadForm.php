<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="hifz">
        <p>الحفظ</p>
        <div class="boxcontainer">
            <label for="hifz">كم سمعت اليوم؟</label>
            <input id="hifz" onkeypress="return onlyNumberKey(event)" name="hifz" value="0" type="number" required autocomplete="off" step="0.5" min=0>
        </div>
    </div>

    <div class="hifz">
        <div class="boxcontainer">
            <label for="hifztasmee3">من فين لفين؟</label>
            <input id="hifztasmee3" name="hifztasme3" type="text" default=null placeholder="اترك فارغا ان لم تسمع" autocomplete="off">
        </div>
    </div>

    <div class="muraja">
        <p>المراجعة</p>
        <div class="boxcontainer">
            <label for="muraja">كم سمعت اليوم؟</label>
            <input onkeypress="return onlyNumberKey(event)" name="muraja" id="muraja" value="0" type="number" required autocomplete="off" step="0.5" min=0>
        </div>
    </div>
    <div class="muraja">
        <div class="boxcontainer">
            <label for="murajatasmee3">من فين لفين؟</label>
            <input id="murajatasmee3" name="murajatasme3" type="text" placeholder="اترك فارغا ان لم تسمع" autocomplete="off">
        </div>
    </div>



    <div class="datebuttonscontainer">
        <label class="datebuttons">
            <input type="radio" name="tdate" value="yesterday">
            <span class="checkmark"></span>
            امس
        </label>

        <label class="datebuttons">
            <input type="radio" checked="checked" name="tdate" value="today">
            <span class="checkmark"></span>
            اليوم
        </label>
    </div>


    <div class="submitbutton">
        <button name="create" type="submit" class="mainbutton"> سجل <i class="fas fa-plus"></i>
        </button>
    </div>
</form>