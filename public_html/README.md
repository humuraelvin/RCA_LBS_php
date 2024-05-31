# atabet
casino

2023-08-19

"array(2) {
  ["denominations"]=>
  array(1) {
    [0]=>
    int(1)
  }
  ["bets"]=>
  array(9) {
    [0]=>
    array(3) {
      ["bet_id"]=>
      string(1) "0"
      ["bet_per_line"]=>
      float(0.05)
      ["lines"]=>
      int(20)
    }
    [1]=>
    array(3) {
      ["bet_id"]=>
      string(1) "1"
      ["bet_per_line"]=>
      float(0.1)
      ["lines"]=>
      int(20)
    }
    [2]=>
    array(3) {
      ["bet_id"]=>
      string(1) "2"
      ["bet_per_line"]=>
      float(0.25)
      ["lines"]=>
      int(20)
    }
    [3]=>
    array(3) {
      ["bet_id"]=>
      string(1) "3"
      ["bet_per_line"]=>
      float(0.5)
      ["lines"]=>
      int(20)
    }
    [4]=>
    array(3) {
      ["bet_id"]=>
      string(1) "4"
      ["bet_per_line"]=>
      float(1.25)
      ["lines"]=>
      int(20)
    }
    [5]=>
    array(3) {
      ["bet_id"]=>
      string(1) "5"
      ["bet_per_line"]=>
      float(2.5)
      ["lines"]=>
      int(20)
    }
    [6]=>
    array(3) {
      ["bet_id"]=>
      string(1) "6"
      ["bet_per_line"]=>
      int(5)
      ["lines"]=>
      int(20)
    }
    [7]=>
    array(3) {
      ["bet_id"]=>
      string(1) "7"
      ["bet_per_line"]=>
      int(15)
      ["lines"]=>
      int(20)
    }
    [8]=>
    array(3) {
      ["bet_id"]=>
      string(1) "8"
      ["bet_per_line"]=>
      int(25)
      ["lines"]=>
      int(20)
    }
  }
}
"


Freespins are not connected for your merchant. If you want to add them, we can first enable FS on your stage where you test them. 
Then, It is necessary on the Stage Merchant to play 3 sessions in which will be played all the Freespins issued to the player + make 3-5 regular spins within the same session.

For each session to provide statistics:
Session 1:
Total Win - the sum of all winnings for real spins (excluding winnings for freespins)
Total Bet - the sum of all bets for real spins
Bonus Total Out - sum of all wins for freespins (excluding wins for real spins)

Session 2:
Total Win - sum of all wins for real spins (excluding wins for freespins)
Total Bet - the sum of all bets for real spins
Bonus Total Out - the sum of all wins for freespins (excluding wins for real spins)

Session 3:
Total Win - sum of all wins for real spins (excluding wins for freespins)
Total Bet - the sum of all bets for real spins
Bonus Total Out - the sum of all winnings for freespins (excluding winnings for real spins)