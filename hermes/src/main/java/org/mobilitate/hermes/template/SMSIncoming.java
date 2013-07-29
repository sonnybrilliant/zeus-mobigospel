/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package org.mobilitate.hermes.template;

import java.io.Serializable;

/**
 *
 * @author ronald
 */
public class SMSIncoming implements Serializable {

private long seqNumber;
  private String msisdn;
  private long networkId;
  private String content;
  private String toAddress;
  private long recordId;

  public SMSIncoming(){

  }

  public String getContent() {
   return content;
  }

  public void setContent(String content) {
    this.content = content;
  }

  public String getMsisdn() {
    return msisdn;
  }

  public void setMsisdn(String msisdn) {
    this.msisdn = msisdn;
  }

  public long getNetworkId() {
    return networkId;
  }

  public void setNetworkId(long networkId) {
    this.networkId = networkId;
  }

  public long getSeqNumber() {
    return seqNumber;
  }

  public void setSeqNumber(long seqNumber) {
    this.seqNumber = seqNumber;
  }

  public String getToAddress() {
    return toAddress;
  }

  public void setToAddress(String toAddress) {
    this.toAddress = toAddress;
  }

  public long getRecordId(){
      return this.recordId;
  }

  public void setRecordId(long id){
      this.recordId = id;
  }
}
