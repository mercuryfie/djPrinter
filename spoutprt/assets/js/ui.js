"use strict";
function tab(e, i) {
    var i = i || 0,
        t = $(e).children(),
        a = $(e + "_Cont").children(),
        s = $(t).eq(i),
        c = i;
    s.addClass("active"),
        a.eq(i).show(),
        t.click(function () {
            null !== s && (s.removeClass("active"), a.eq(c).hide()),
                (s = $(this)),
                (c = $(this).index()),
                s.addClass("active"),
                a.eq(c).show();
        });
}
$('#tabBox2').css('color','red');
$(function () {
    tab("#tab", 0);
});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiZnVuY3Rpb24uanMiLCJzb3VyY2VzIjpbImZ1bmN0aW9uLmpzIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xuXG4kKGZ1bmN0aW9uICgpIHtcbiAgdGFiKCcjdGFiJywgMCk7XG59KTtcblxuZnVuY3Rpb24gdGFiKGUsIG51bSkge1xuICB2YXIgbnVtID0gbnVtIHx8IDA7XG4gIHZhciBtZW51ID0gJChlKS5jaGlsZHJlbigpO1xuICB2YXIgY29uID0gJChlICsgJ19Db250JykuY2hpbGRyZW4oKTtcbiAgdmFyIHNlbGVjdCA9ICQobWVudSkuZXEobnVtKTtcbiAgdmFyIGkgPSBudW07XG4gIHNlbGVjdC5hZGRDbGFzcygnYWN0aXZlJyk7XG4gIGNvbi5lcShudW0pLnNob3coKTtcbiAgbWVudS5jbGljayhmdW5jdGlvbiAoKSB7XG4gICAgaWYgKHNlbGVjdCAhPT0gbnVsbCkge1xuICAgICAgc2VsZWN0LnJlbW92ZUNsYXNzKFwiYWN0aXZlXCIpO1xuICAgICAgY29uLmVxKGkpLmhpZGUoKTtcbiAgICB9XG5cbiAgICBzZWxlY3QgPSAkKHRoaXMpO1xuICAgIGkgPSAkKHRoaXMpLmluZGV4KCk7XG4gICAgc2VsZWN0LmFkZENsYXNzKCdhY3RpdmUnKTtcbiAgICBjb24uZXEoaSkuc2hvdygpO1xuICB9KTtcbn0iXSwibmFtZXMiOlsidGFiIiwiZSIsIm51bSIsIm1lbnUiLCIkIiwiY2hpbGRyZW4iLCJjb24iLCJzZWxlY3QiLCJlcSIsImkiLCJhZGRDbGFzcyIsInNob3ciLCJjbGljayIsInJlbW92ZUNsYXNzIiwiaGlkZSIsInRoaXMiLCJpbmRleCJdLCJtYXBwaW5ncyI6ImFBTUEsU0FBU0EsSUFBSUMsRUFBR0MsR0FDZCxJQUFJQSxFQUFNQSxHQUFPLEVBQ2JDLEVBQU9DLEVBQUVILEdBQUdJLFdBQ1pDLEVBQU1GLEVBQUVILEVBQUksU0FBU0ksV0FDckJFLEVBQVNILEVBQUVELEdBQU1LLEdBQUdOLEdBQ3BCTyxFQUFJUCxFQUNSSyxFQUFPRyxTQUFTLFVBQ2hCSixFQUFJRSxHQUFHTixHQUFLUyxPQUNaUixFQUFLUyxNQUFNLFdBQ00sT0FBWEwsSUFDRkEsRUFBT00sWUFBWSxVQUNuQlAsRUFBSUUsR0FBR0MsR0FBR0ssUUFHWlAsRUFBU0gsRUFBRVcsTUFDWE4sRUFBSUwsRUFBRVcsTUFBTUMsUUFDWlQsRUFBT0csU0FBUyxVQUNoQkosRUFBSUUsR0FBR0MsR0FBR0UsU0FyQmRQLEVBQUUsV0FDQUosSUFBSSxPQUFRIn0=

("use strict");
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoibW9kYWwuanMiLCJzb3VyY2VzIjpbXSwic291cmNlc0NvbnRlbnQiOltdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiIn0=
