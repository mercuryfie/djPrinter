<?php
	$root="../spoutprt";
?>
<div class="work">
  <div class="wrap">
	<div class="work__tit">
	  작업 대기중<span id="tcnt">0</span>
		<span onclick="setting('label')" class="manual">수동마킹</span>
	</div>
	<div class="workTable">
	  <div class="table">
		<table id="listtbl">
		  <colgroup>
			<col>
			<col>
			<col>
		  </colgroup>
		  <thead>
			<tr>
			  <th>주문코드</th>
			  <th>한의원 / 주문자</th>
			  <th>처방명</th>
			</tr>
		  </thead>
		  <tbody></tbody>
		</table>
	  </div>
	</div>
	<div class="pagination" id="pagediv"></div>
  </div>
</div>
<script>
</script>