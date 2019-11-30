/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//function calculate validates user input and calculates totals
function calculate( name, bv, amt, tlbv, tlamt)
    {
        var qty = name.value
        if (isNaN(qty))alert("Please enter only numbers")
        if(qty > 0)
            {
                var prdtBv = qty*bv;
                var prdtAmt= qty*amt;
                /*TotalAmt = document.getElementById(tamt);
                TotalBv = document.getElementById(tbv);

                TotalAmt += prdtAmt;
                TotalBv += prdtBv;*/

                document.getElementById(tlbv).innerHTML = prdtBv;
                document.getElementById(tlamt).innerHTML = prdtAmt;
               // document.getElementById(tbv).innerHTML = TotalBv;
               // document.getElementById(tamt).innerHTML = TotalAmt;

            }
    }