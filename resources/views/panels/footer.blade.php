<footer class="footer footer-light @if(isset($configData['footerType'])){{$configData['footerClass']}}@endif">
  <p class="clearfix mb-0">
    <span class="float-left d-inline-block">Bio-Manguinhos</span>
    <span class="float-right d-sm-inline-block d-none"><strong>Copyright &copy; {{ date("Y")  }}
      <a href="https://portal.fiocruz.br/" target="_blank">FioTec</a>.</strong> Todos os direitos reservados.</a>
    </span>
    @if($configData['isScrollTop'] === true)
    <button class="btn btn-primary btn-icon scroll-top" type="button">
      <i class="bx bx-up-arrow-alt"></i>
    </button>
    @endif
  </p>
</footer>
