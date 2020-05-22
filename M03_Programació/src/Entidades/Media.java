/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entidades;

import java.io.Serializable;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Lob;
import javax.persistence.NamedQueries;
import javax.persistence.NamedQuery;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;
import javax.xml.bind.annotation.XmlRootElement;

/**
 *
 * @author Eduard
 */
@Entity
@Table(name = "media")
@XmlRootElement
@NamedQueries({
    @NamedQuery(name = "Media.findAll", query = "SELECT m FROM Media m")
    , @NamedQuery(name = "Media.findById", query = "SELECT m FROM Media m WHERE m.id = :id")
    , @NamedQuery(name = "Media.findByModelType", query = "SELECT m FROM Media m WHERE m.modelType = :modelType")
    , @NamedQuery(name = "Media.findByModelId", query = "SELECT m FROM Media m WHERE m.modelId = :modelId")
    , @NamedQuery(name = "Media.findByCollectionName", query = "SELECT m FROM Media m WHERE m.collectionName = :collectionName")
    , @NamedQuery(name = "Media.findByName", query = "SELECT m FROM Media m WHERE m.name = :name")
    , @NamedQuery(name = "Media.findByFileName", query = "SELECT m FROM Media m WHERE m.fileName = :fileName")
    , @NamedQuery(name = "Media.findByMimeType", query = "SELECT m FROM Media m WHERE m.mimeType = :mimeType")
    , @NamedQuery(name = "Media.findByDisk", query = "SELECT m FROM Media m WHERE m.disk = :disk")
    , @NamedQuery(name = "Media.findBySize", query = "SELECT m FROM Media m WHERE m.size = :size")
    , @NamedQuery(name = "Media.findByOrderColumn", query = "SELECT m FROM Media m WHERE m.orderColumn = :orderColumn")
    , @NamedQuery(name = "Media.findByCreatedAt", query = "SELECT m FROM Media m WHERE m.createdAt = :createdAt")
    , @NamedQuery(name = "Media.findByUpdatedAt", query = "SELECT m FROM Media m WHERE m.updatedAt = :updatedAt")})
public class Media implements Serializable {

    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id")
    private Integer id;
    @Basic(optional = false)
    @Column(name = "model_type")
    private String modelType;
    @Basic(optional = false)
    @Column(name = "model_id")
    private long modelId;
    @Basic(optional = false)
    @Column(name = "collection_name")
    private String collectionName;
    @Basic(optional = false)
    @Column(name = "name")
    private String name;
    @Basic(optional = false)
    @Column(name = "file_name")
    private String fileName;
    @Column(name = "mime_type")
    private String mimeType;
    @Basic(optional = false)
    @Column(name = "disk")
    private String disk;
    @Basic(optional = false)
    @Column(name = "size")
    private int size;
    @Basic(optional = false)
    @Lob
    @Column(name = "manipulations")
    private String manipulations;
    @Basic(optional = false)
    @Lob
    @Column(name = "custom_properties")
    private String customProperties;
    @Basic(optional = false)
    @Lob
    @Column(name = "responsive_images")
    private String responsiveImages;
    @Column(name = "order_column")
    private Integer orderColumn;
    @Column(name = "created_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt;
    @Column(name = "updated_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt;

    public Media() {
    }

    public Media(Integer id) {
        this.id = id;
    }

    public Media(Integer id, String modelType, long modelId, String collectionName, String name, String fileName, String disk, int size, String manipulations, String customProperties, String responsiveImages) {
        this.id = id;
        this.modelType = modelType;
        this.modelId = modelId;
        this.collectionName = collectionName;
        this.name = name;
        this.fileName = fileName;
        this.disk = disk;
        this.size = size;
        this.manipulations = manipulations;
        this.customProperties = customProperties;
        this.responsiveImages = responsiveImages;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getModelType() {
        return modelType;
    }

    public void setModelType(String modelType) {
        this.modelType = modelType;
    }

    public long getModelId() {
        return modelId;
    }

    public void setModelId(long modelId) {
        this.modelId = modelId;
    }

    public String getCollectionName() {
        return collectionName;
    }

    public void setCollectionName(String collectionName) {
        this.collectionName = collectionName;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getFileName() {
        return fileName;
    }

    public void setFileName(String fileName) {
        this.fileName = fileName;
    }

    public String getMimeType() {
        return mimeType;
    }

    public void setMimeType(String mimeType) {
        this.mimeType = mimeType;
    }

    public String getDisk() {
        return disk;
    }

    public void setDisk(String disk) {
        this.disk = disk;
    }

    public int getSize() {
        return size;
    }

    public void setSize(int size) {
        this.size = size;
    }

    public String getManipulations() {
        return manipulations;
    }

    public void setManipulations(String manipulations) {
        this.manipulations = manipulations;
    }

    public String getCustomProperties() {
        return customProperties;
    }

    public void setCustomProperties(String customProperties) {
        this.customProperties = customProperties;
    }

    public String getResponsiveImages() {
        return responsiveImages;
    }

    public void setResponsiveImages(String responsiveImages) {
        this.responsiveImages = responsiveImages;
    }

    public Integer getOrderColumn() {
        return orderColumn;
    }

    public void setOrderColumn(Integer orderColumn) {
        this.orderColumn = orderColumn;
    }

    public Date getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(Date createdAt) {
        this.createdAt = createdAt;
    }

    public Date getUpdatedAt() {
        return updatedAt;
    }

    public void setUpdatedAt(Date updatedAt) {
        this.updatedAt = updatedAt;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (id != null ? id.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof Media)) {
            return false;
        }
        Media other = (Media) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "Entidades.Media[ id=" + id + " ]";
    }
    
}
