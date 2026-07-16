<div class="modal fade" id="modalAdvancedSearch" tabindex="-1" role="dialog" aria-label="myModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="tt-modal-advancedSearch">
                <div class="tt-modal-title">
                    <i class="pt-icon">
                        <svg>
                            <use xlink:href="#icon-advanced_search"></use>
                        </svg>
                    </i>
                    Soru Arama Motoru
                    <a class="pt-close-modal" href="#" data-dismiss="modal">
                        <svg class="icon">
                            <use xlink:href="#icon-cancel"></use>
                        </svg>
                    </a>
                </div>
                <form class="form-default" action="{{ route('front.search') }}" method="GET">
                    <div class="form-group">
                        <label for="searchCategory">Yazı Başlığı</label>
                        <input type="text" name="aranan" class="form-control" id="searchCategory" placeholder="Arama Yap">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary btn-block"><i class="fa fa-search"></i> Ara</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
