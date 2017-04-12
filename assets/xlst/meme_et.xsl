<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
	<xsl:for-each select="memes/meme">
    <div class="container-fluid"><div class="break"></div></div>

    <div class="container-fluid">
      <xsl:element name="div">
          <xsl:attribute name="class">
                meme-container
		      </xsl:attribute>
          <xsl:attribute name="data-id">
			       <xsl:value-of select="id"/>
		      </xsl:attribute>
        <div class="col-xs-12 col-custom-frontpage col-centered">
          <div class="meme">

            <h2><xsl:element name="a">
              <xsl:attribute name="href">
  			       <xsl:value-of select="link"/>
  		        </xsl:attribute>
              <xsl:value-of select="title"/>
            </xsl:element></h2>

            <xsl:if test="datatype='P'">
              <xsl:element name="img">
                <xsl:attribute name="alt">
    			       <xsl:value-of select="title"/>
    		        </xsl:attribute>
                <xsl:attribute name="src">
    			       https://res.cloudinary.com/spicy-memes/image/upload/t_meme/<xsl:value-of select="data"/>
    		        </xsl:attribute>
              </xsl:element>
            </xsl:if>
            <xsl:if test="datatype='V'">
              <div class="embed-responsive embed-responsive-16by9">
                <xsl:element name="iframe">
                  <xsl:attribute name="class">
                    embed-responsive-item
                  </xsl:attribute>
                  <xsl:attribute name="src">
      			       https://www.youtube.com/embed/<xsl:value-of select="data"/>
      		        </xsl:attribute>
                  <xsl:attribute name="allowfullscreen">
      		        </xsl:attribute>
                </xsl:element>
              </div>
            </xsl:if>

          </div>

          <div class="memedata">
            <p>Vürtsikus: <span class="points badge"><xsl:value-of select="points"/></span></p>
            <p>Autor: <xsl:element name="a"><xsl:attribute name="href">
             <xsl:value-of select="profile"/>
           </xsl:attribute><xsl:value-of select="uploader"/></xsl:element></p>
            <p>Kommentaarid: <xsl:element name="a"><xsl:attribute name="href"><xsl:value-of select="link"/>#comments</xsl:attribute><span class="badge"><xsl:value-of select="comments"/></span></xsl:element></p>
          </div>

          <div class="updownvote-frontpage">
            <a role="button" class="btn btn-upvotes btn-md"><xsl:element name="span"><xsl:attribute name="class">glyphicon glyphicon-arrow-up upvote <xsl:if test="vote=1">active-vote</xsl:if></xsl:attribute></xsl:element></a>
            <a role="button" class="btn btn-downvotes btn-md"><xsl:element name="span"><xsl:attribute name="class">glyphicon glyphicon-arrow-down downvote <xsl:if test="vote=-1">active-vote</xsl:if></xsl:attribute></xsl:element></a>
          </div>
        </div>
        </xsl:element>
    </div>
	</xsl:for-each>
</xsl:template>
</xsl:stylesheet>
