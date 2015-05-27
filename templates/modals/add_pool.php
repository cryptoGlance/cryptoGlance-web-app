<!-- Modal -->
<div class="modal fade" id="addPool" tabindex="-1" role="dialog" aria-labelledby="addPoolLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           <h2 class="modal-title" id="addPoolLabel"><i class="icon icon-circleadd"></i> Add a Mining Pool</h2>
         </div>
         <div class="modal-body">
           <div class="form-group all">
             <label for="inputPoolLabel" class="col-sm-3 control-label">Label</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputPoolLabel" name="label" placeholder="Name of this pool">
             </div>
           </div>
          <div class="form-group all">
            <label for="selectPoolType" class="col-sm-3 control-label">Type</label>
            <div class="col-sm-6">
              <select class="form-control" id="selectPoolType" name="poolType">
                 <option disabled selected>Select A Pool</option>
                 <option value="antpool">Antpool</option>
                 <option value="bitminter">BitMinter</option>
                 <option value="btcguild">BTC Guild</option>
                 <option value="bitcoinaffiliatenetwork">Bitcoin Affiliate Network</option>
                 <option value="slush">BitcoinCZ aka Slush</option>
                 <option value="burstninja">Burst.Ninja</option>
                 <option value="ckpool">CkPool</option>
                 <option value="eclipse">Eclipse</option>
                 <option value="eligius">Eligius</option>
                 <option value="magicpool">MagicPool</option>
                 <option value="mpos">MPOS</option>
                 <option value="multipoolus">Multipool.us</option>
                 <option value="nicehash">NiceHash</option>
                 <option value="nomp">NOMP</option>
                 <option value="p2pool">P2Pool</option>
                 <!-- <option value="simplecoin">SimpleCoin</option> -->
                 <!-- <option value="trademybit">TradeMyBit</option> -->
                 <option value="wafflepool">WafflePool</option>
                 <option value="westhash">WestHash</option>
              </select>
            </div>
          </div>
           <div class="form-group mpos simplecoin nomp ckpool p2pool" style="display: none;">
             <label for="inputPoolURL" class="col-sm-3 control-label">Pool URL</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputPoolURL" name="url" placeholder="http://pooldomain.com/">
             </div>
           </div>
           <div class="form-group mpos bitcoinaffiliatenetwork btcguild simplecoin eclipse trademybit multipoolus ckpool slush antpool bitminter" style="display: none;">
             <label for="inputPoolAPI" class="col-sm-3 control-label">API Key</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputPoolAPI" name="api">
             </div>
           </div>
           <div class="form-group antpool" style="display: none;">
             <label for="inputPoolSecret" class="col-sm-3 control-label">API Secret</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputPoolSecret" name="secret">
             </div>
           </div>
           <div class="form-group mpos bitcoinaffiliatenetwork ckpool antpool bitminter burstninja" style="display: none;">
             <label for="inputPoolUserId" class="col-sm-3 control-label">User ID</label>
             <div class="col-sm-4">
               <input type="text" class="form-control" id="inputPoolUserId" name="userid">
             </div>
           </div>
           <div class="form-group wafflepool eligius magicpool nomp p2pool nicehash westhash" style="display: none;">
             <label for="inputAddress" class="col-sm-3 control-label">Mining Address</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputAddress" name="address" placeholder="12PqYifLLTHuU2jRxTtbbJBFjkuww3zeeE">
             </div>
           </div>
           <div class="form-group nomp" style="display: none;">
             <label for="inputCoin" class="col-sm-3 control-label">Coin</label>
             <div class="col-sm-7">
               <input type="text" class="form-control" id="inputCoin" name="coin" placeholder="megacoin">
             </div>
           </div>
           <div class="form-group">
             <div class="col-sm-12">
                 <span class="error"></span>
             </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-lg btn-danger btn-cancelConfig" data-dismiss="modal"><i class="icon icon-undo"></i> Cancel</button>
           <button type="button" class="btn btn-lg btn-success btn-saveConfig" id="btnAddPool"><i class="icon icon-save-floppy"></i> Save</button>
         </div>
         <input type="hidden" name="type" value="pools" />
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
