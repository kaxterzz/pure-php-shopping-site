// JavaScript Document      
		function startTime()
		{
		var today=new Date();
		var h=today.getHours();
		var m=today.getMinutes();
		var s=today.getSeconds();
		var y=today.getFullYear();
		var mon=today.getMonth();
		var d=today.getDate();
		//var date=today.get();
		// add a zero in front of numbers<10
		h=checkTime(h);
		m=checkTime(m);
		s=checkTime(s);
		y=checkTime(y);
		mon=checkTime(mon);
		d=checkTime(d);
		document.getElementById('clock').innerHTML=y+"-"+(Number(mon)+1)+"-"+d+"  "+h+":"+m+":"+s;
		t=setTimeout(function(){startTime()},500);
		}
		
		function checkTime(i)
		{
		if (i<10)
		  {
		  i="0" + i;
		  }
		return i;
		}